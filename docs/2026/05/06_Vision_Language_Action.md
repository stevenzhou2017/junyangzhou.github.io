# VLA（Vision-Language-Action）技术详解

author: 周均扬

date： 2026.05.14

---

VLA（Vision-Language-Action）是当前具身智能（Embodied AI）与机器人领域的重要方向，其核心目标是：

> **让机器人像人一样，通过“看”（Vision）+“理解语言”（Language）+“执行动作”（Action）完成复杂任务。**

它本质上是：

> 从“感知模型”进化为“世界交互模型（World Interaction Model）”。

典型代表包括：

* Google DeepMind 的 RT-2
* OpenAI 的机器人策略研究
* Tesla Optimus 的端到端控制
* NVIDIA 的 GR00T
* Figure AI 的 Figure 01
* Physical Intelligence 的 π0

---

## 1. VLA 的本质

传统 AI：

```text
输入 → 分类/预测 → 输出
```

VLA：

```text
感知世界 → 理解语义 → 推理目标 → 生成动作序列 → 与物理世界闭环交互
```

因此： VLA 的本质 =  “语言驱动的视觉条件动作生成模型”  或者： “世界状态到动作轨迹的概率映射器”

数学表达：

设：

* 视觉输入：$V_t$

* 语言指令：$L$

* 历史状态：$H_t$

则 VLA 学习： $P(A_t \mid V_t,L,H_t)$

即：

> 在当前视觉、语言与历史状态条件下，
> 生成最优动作。

---

## 2. VLA 为什么重要

因为传统机器人存在三个根本问题：

| 问题      | 传统方法缺陷       |
| ------- | ------------ |
| 泛化差     | 每个任务都要重新编程   |
| 缺少语义理解  | 不理解“帮我整理桌子”  |
| 感知与控制割裂 | CV、规划、控制独立开发 |

VLA 的目标：用一个统一模型：

```text
视觉 → 语言理解 → 推理 → 动作
```

全部端到端学习。

---

## 3. VLA 技术架构

典型 VLA：

```text
Camera
   ↓
Vision Encoder
   ↓
Visual Tokens
   ↓
LLM / Transformer
   ↓
Action Tokens
   ↓
Robot Controller
   ↓
Motor
```

---

## 4. 核心技术模块

---

### 1. Vision Encoder（视觉编码器）

负责：

```text
图像 → Token
```

常见模型：

* ViT
* SigLIP
* EVA
* DINOv2

本质：把视觉变成 Transformer 可处理的 token。

例如： 一张图：

```text
224×224×3
```

切分：

```text
16×16 patch
```

得到：

```text
196 visual tokens
```

数学：

设图像：$I \in R^{H\times W\times C}$

Patch embedding：$x_i = W_p \cdot patch_i + b$

得到视觉 token：$X=[x_1,x_2,...,x_n]$

---

### 2. Language Model（语言模型）

这是 VLA 的“大脑”。

负责：

* 指令理解
* 推理
* 任务规划
* 世界建模
* 动作生成

典型：

* Transformer
* 多模态 LLM
* Diffusion Transformer

核心：统一 token 空间。即：

```text
文本 token
视觉 token
动作 token
```

全部进入一个 Transformer。

---

### 3. Action Tokenization（动作离散化）

这是 VLA 最大创新之一。

机器人动作：

本来是连续值：

```text
(x,y,z,roll,pitch,yaw,gripper)
```

例如：

```text
(0.23, -0.18, 0.5, ...)
```

难以直接生成。

于是：把动作“token 化”。

类似 NLP 的词。

例如：

```text
MOVE_LEFT_SMALL
GRASP
ROTATE_10_DEG
```

或者量化：$a \in [-1,1]$, 离散成256 bins。

即：$a_q = \operatorname{round}\left(\frac{a-a_{min}}{a_{max}-a_{min}}\times255\right)$。 

这样：Transformer 就能像生成文字一样生成动作。

---

## 5. VLA 的核心数学

---

### 1. Sequence Modeling

本质：VLA 是序列生成。

目标：$P(a_1,a_2,...,a_T \mid V,L)$

Transformer：

自回归：$P(A)=\prod_t P(a_t|a_{<t},V,L)$

---

### 2. Attention 机制

核心：

模型决定：

> “当前动作该关注图像哪里”。

Attention：$\operatorname{Attention}(Q,K,V)=\operatorname{softmax}\left(\frac{QK^T}{\sqrt{d}}\right)V$

例如： “拿起红色杯子”

Attention 自动关注：

```text
红色区域
杯子边缘
手的位置
```

---

### 3. Behavior Cloning（行为克隆）

VLA 大多先监督学习：$(V,L)\rightarrow A$

损失：$\mathcal{L}=-\sum_t \log P(a_t^*\mid V,L,a_{<t})#

即：模仿人类示范。

---

### 4. Reinforcement Learning（强化学习）

进一步优化：

奖励：$R(s,a)$

目标：$J(\theta)=\mathbb{E}*{\pi*\theta}\left[\sum_t \gamma^t r_t\right]$

实现：

* 更稳定动作
* 更高成功率
* 更长任务链

---

## 6. VLA 与传统机器人区别

| 维度   | 传统机器人   | VLA         |
| ---- | ------- | ----------- |
| 编程方式 | 手工规则    | 数据驱动        |
| 感知   | 单独CV模块  | 端到端         |
| 控制   | PID/规划器 | Transformer |
| 泛化   | 极差      | 强           |
| 新任务  | 重新开发    | 自然语言        |
| 推理能力 | 无       | 有           |

---

## 7. VLA 与自动驾驶的关系

其实：**自动驾驶本质也是 VLA**

因为：

```text
Camera → 理解世界 → 生成驾驶动作
```

例如：

Tesla FSD：

```text
视频输入
↓
Transformer
↓
方向盘/油门/刹车
```

与机器人完全同构。

所以：**VLA 本质是“通用物理世界 Agent”**。

---

## 8. 当前主流 VLA 系统

---

### 1. RT-2

来自：Google DeepMind

创新：把机器人动作当作“语言 token”。

即：

```text
text + image + action
```

统一 Transformer。

突破：

* 零样本泛化
* 推理能力
* 语义理解

例如：

```text
“把快要融化的东西放进冰箱”
```

机器人理解：

```text
冰激凌会融化
```

---

### 2. OpenVLA

开源代表。

特点：

* 基于 Llama
* HuggingFace 生态
* 低成本训练

适合：

* 学术研究
* 二次开发

---

### 3. π0（Physical Intelligence）

目标：

统一：

```text
所有机器人
所有任务
所有场景
```

类似：

```text
GPT for Robotics
```

---

## 9. VLA 的真正难点

很多人以为：LLM 是难点。

其实不是。

真正困难：

---

### 1. 数据

机器人数据极贵。

因为：

```text
每条数据 = 真实物理动作
```

不能像互联网抓文本。

问题：

* 数据少
* 标注难
* 长尾多
* 失败成本高

---

### 2. Sim2Real（仿真到现实）

仿真里成功：

现实失败。

原因：

```text
摩擦
光照
遮挡
噪声
材料形变
```

与现实不一致。

---

### 3. 长时序任务

例如：

```text
做早餐
```

需要：

* 多步骤规划
* 记忆
* 容错
* 中间状态恢复

这是当前巨大瓶颈。

---

### 4. 实时性

机器人控制：

通常：
```text
10~100Hz
```

但大模型推理：太慢。

因此, 当前大量研究：

* Action Chunking
* Diffusion Policy
* Tiny VLA
* MoE Routing

---

## 10. VLA 的未来方向

---

### 1. World Model（世界模型）

核心：机器人不仅生成动作。还预测未来。

即：$P(S_{t+1}\mid S_t,A_t)$

类似：“大脑中的物理模拟器”。

---

### 2. Diffusion Policy

不用 token。直接生成连续动作轨迹：$\tau=(a_1,a_2,...)$

本质：动作扩散模型。

---

### 3. Hierarchical VLA

分层：

```text
高层：
“整理房间”

低层：
抓取、移动、避障
```

类似人脑：

```text
前额叶 + 小脑
```

---

### 4. Self-Improving Robot

机器人自主学习：

```text
观察
尝试
失败
修正
```

长期， 可能出现：“机器人经验互联网”。

---

## 11. VLA 的应用场景

---

### 1. 人形机器人

代表：

* Tesla Optimus
* Figure AI
* Agility Robotics

任务：

* 搬运
* 分拣
* 家务
* 装配

---

### 2. 工业自动化

工业 VLA：

未来可能替代：

```text
大量固定流程PLC逻辑
```

优势：

* 柔性制造
* 小批量生产
* 自适应抓取

这与你之前关注的工业视觉方向高度相关。

---

### 3. 自动驾驶

本质：车轮机器人。

---

### 4. 医疗机器人

例如：

* 手术辅助
* 康复
* 护理

---

### 5. 无人仓储

例如：

* Picking
* Packing
* AMR协同

---

## 12. VLA 的产业意义

VLA 很可能是 “机器人领域的 GPT 时刻”，因为它第一次实现：

```text
感知
推理
动作
```

统一建模。 这意味着，机器人从：

```text
工具
```

变成：

```text
Agent
```

---

## 13. 一句话总结

VLA 的本质：

> 用 Transformer 把视觉、语言与动作统一到同一个 token 世界中，
> 学习“世界状态 → 动作轨迹”的概率映射，
> 从而让机器人具备通用任务理解与物理交互能力。
