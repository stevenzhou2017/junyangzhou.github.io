# Stable Diffusion(SD，稳定扩散)
author: 周均扬
date: 2026.05.09

---

Stable Diffusion 是 **Diffusion Model 的一种优化变体**，核心创新在于 **潜空间扩散（Latent Diffusion）**：

* **核心思路**：

  1. 将高分辨率图像 $x_0 \in \mathbb{R}^{H \times W \times 3}$ 映射到潜空间 $z \in \mathbb{R}^{h \times w \times c}$，通常 $h \ll H, w \ll W$。
  2. 在低维潜空间进行扩散训练和生成，降低计算成本。
  3. 再通过解码器 (Dec(z)) 恢复到高分辨率图像。

* **技术流程**：

  ```text
  文本条件 y → 文本编码 → 融合潜空间 z
  z_t + 噪声 → 反向扩散 → z_0
  z_0 → 解码器 Dec(z_0) → 高分辨率图像 x_0
  ```

* **使用条件生成**：

  * 通过 CLIP 文本嵌入或者其他文本编码作为条件
  * 可以生成指定语义、风格、构图的图像


下面从本质、解决的问题、数学原理和推导、以及应用领域逐层展开全面、系统地解析 **Stable Diffusion (SD)**。

---

## 一、Stable Diffusion 的本质

Stable Diffusion 是一种 **基于扩散模型（Diffusion Model）的文本到图像生成模型**，本质上属于 **条件生成模型（Conditional Generative Model）**。它可以将自然语言描述（Prompt）转换为高质量的图像。

核心思想是：

1. **正向过程（Forward Process）**：把数据（图像）逐步添加噪声，最终变成接近高斯噪声的分布。
2. **逆向过程（Reverse Process）**：从纯噪声开始，逐步去噪，重建出原始图像。Stable Diffusion 通过 **条件约束（文本或其他条件）** 指导逆向去噪，使生成图像符合指定语义。

相比传统 GAN 或 VAE，扩散模型更稳定、生成质量高，并且能自然地表示数据的不确定性。

---

## 二、Stable Diffusion 解决的问题

1. **高质量图像生成**：可以从文本描述生成分辨率较高、细节丰富的图像。
2. **可控性**：通过条件（文本、图像、掩码等）控制生成内容。
3. **训练稳定性**：相比 GAN，避免了模式崩溃（Mode Collapse）问题。
4. **潜空间操作**：通过引入 **潜在空间（Latent Space）**，显著降低计算成本，实现高分辨率生成。

> Stable Diffusion 相比早期扩散模型的主要创新是 **在潜在空间（Latent Space）而非像素空间做扩散**，降低了计算复杂度，同时保留了高质量生成能力。

---

## 三、Stable Diffusion 的数学原理与推导

### 1. 正向扩散过程（Forward Diffusion）

假设真实图像为 (x_0)，将其逐步加噪声：

$$q(x_t | x_{t-1}) = \mathcal{N}(x_t; \sqrt{1-\beta_t} x_{t-1}, \beta_t I)$$

其中：

* (t = 1, 2, ..., T) 表示扩散步骤
* $\beta_t$ 是噪声调度参数（通常小于 1）
* $x_T$ 接近高斯噪声

累积公式可写作：

$$x_t = \sqrt{\alpha_t} x_0 + \sqrt{1 - \alpha_t} \epsilon, \quad \epsilon \sim \mathcal{N}(0, I)$$

这里 $\alpha_t = \prod_{s=1}^{t} (1 - \beta_s)$。

---

### 2. 逆向去噪过程（Reverse Diffusion）

目标是从噪声 $x_T$ 重建图像 $x_0$：

$$p_\theta(x_{t-1} | x_t) = \mathcal{N}\big(x_{t-1}; \mu_\theta(x_t, t), \Sigma_\theta(x_t, t)\big)$$

核心是学习去噪函数 $\epsilon_\theta(x_t, t)$，预测噪声：

$$\mu_\theta(x_t, t) = \frac{1}{\sqrt{\alpha_t}} \Big(x_t - \frac{1-\alpha_t}{\sqrt{1-\bar{\alpha}*t}} \epsilon*\theta(x_t, t) \Big)$$

训练目标是 **最小化预测噪声与真实噪声的 MSE**：

$$\mathcal{L}(\theta) = \mathbb{E}*{x_0, \epsilon, t} \big[ | \epsilon - \epsilon*\theta(x_t, t) |^2 \big]$$

> 换句话说，模型学习如何从一个噪声图像中恢复原始图像。

---

### 3. 条件生成（Conditional Generation）

Stable Diffusion 使用 **文本编码器（如 CLIP 的文本嵌入）** 作为条件 (c)：

$$\epsilon_\theta(x_t, t, c)$$

这样，在去噪的每一步都引导生成图像与文本语义一致。

---

### 4. 潜在空间扩散

为了降低计算成本，SD 将图像编码到 **潜在空间 $z_0 = \text{VAE}_{\text{encoder}}(x_0)$**，在潜在空间做扩散：

1. Encode: $x_0 \rightarrow z_0$
2. Diffusion: $z_0 \xrightarrow{\text{forward noising}} z_T$
3. Reverse: $z_T \xrightarrow{\text{denoising}} z_0$
4. Decode: $z_0 \rightarrow x_0$

这样可以生成 512×512 以上分辨率图像，而计算量大幅下降。

---

### 5. 总结数学关系

$$x_0 \xrightarrow{\text{VAE encoder}} z_0 \xrightarrow{\text{forward diffusion}} z_T \xrightarrow{\text{conditional reverse}} z_0 \xrightarrow{\text{VAE decoder}} x_0$$

关键训练目标：$\min_\theta \mathbb{E}*{z_t, t, c} || \epsilon - \epsilon*\theta(z_t, t, c) ||^2$

---

## 四、Stable Diffusion 的应用领域

1. **文本到图像生成（Text-to-Image）**

   * 如艺术创作、插画、广告设计

2. **图像编辑与修复（Inpainting / Outpainting）**

   * 去除或修改图像内容，补全缺失部分

3. **风格迁移与图像增强（Style Transfer / Super-Resolution）**

   * 生成特定风格或提高分辨率

4. **3D 内容生成与游戏素材**

   * 根据文本生成 3D 模型的渲染图或场景

5. **科学可视化与模拟**

   * 医学影像、材料科学可视化

6. **潜在空间操作**

   * 图像属性编辑（如改变性别、表情、季节）

---

## 五、 与Diffusion Model 对比

| 特性   | Diffusion Model | Stable Diffusion             |
| ---- | --------------- | ---------------------------- |
| 生成空间 | 原始像素空间          | 潜空间（低维）                      |
| 计算量  | 高，逐像素操作         | 低，潜空间操作节省显存                  |
| 分辨率  | 固定或低            | 可扩展到高分辨率（512x512~1024x1024+） |
| 条件生成 | 可选              | 可控（文本、标签、图像）                 |
| 采样速度 | 慢（1000步左右）      | 快（50-100步即可）                 |
| 可扩展性 | 多模态通用           | 高分辨率图像、风格迁移、编辑能力强            |
| 典型应用 | 图像生成、视频、动作      | 文生图、图像编辑、AI绘画                |

✅ **核心优势**：

1. **计算高效**：在潜空间训练，节省显存和显著加速采样。
2. **高分辨率生成**：可生成 1024x1024 或更高分辨率图像，而不牺牲质量。
3. **条件可控**：文本、草图、风格、图像可作为条件输入。
4. **可编辑性强**：可在潜空间对局部进行修改，支持 inpainting、outpainting。
5. **社区生态丰富**：大量开源模型（SD1.5/SD2.1/SDXL）、可扩展插件和工具。


## 六、总结

Stable Diffusion 的核心亮点：

* **本质**：条件扩散生成模型，在潜在空间完成高效生成。
* **解决的问题**：高质量、可控、训练稳定的图像生成。
* **数学核心**：正向加噪 + 逆向去噪 + 条件约束；优化噪声预测 MSE。
* **应用广泛**：文本生成图像、图像编辑、风格迁移、3D素材生成等。
