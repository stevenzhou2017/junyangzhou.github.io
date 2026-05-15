# VLA（Vision-Language-Action）

author: 周均扬

date: 2026.05.14

---

VLA（Vision-Language-Action）是当前具身智能（Embodied AI）、人形机器人、智能自动化与下一代 AI Agent 的核心方向之一。

它试图解决一个过去几十年机器人领域始终没有真正解决的问题：

> 如何让机器像人一样，
> “看懂世界 → 理解任务 → 执行动作 → 与物理世界闭环交互”。

传统 AI：

```text id="5x3vfy"
识别世界
```

VLA：

```text id="kl8kj2"
操作世界
```

这是 AI 的一次根本性跃迁。

---

## 1. VLA 的本质

VLA 的本质不是"视觉模型 + 大语言模型 + 机械臂", 而是 “统一世界状态与动作生成的概率模型”， 即机器人通过：

* 视觉（Vision）
* 语言（Language）
* 历史状态（History）
* 动作反馈（Action Feedback）

共同建模 “下一步应该如何行动”。

数学上：

设 当前视觉观测$V_t$，语言指令$L$，历史状态$H_t$，当前动作$A_t$，

VLA 的核心目标：$P(A_t \mid V_t,L,H_t)$，即：

> 在当前世界状态与任务目标条件下，
> 生成最优动作。

因此 VLA 本质上是“物理世界动作生成模型”。

它与 GPT 的区别：

| GPT         | VLA     |
| ----------- | ------- |
| 预测下一个 token | 预测下一步动作 |
| 输出文本        | 输出物理行为  |
| 面向信息世界      | 面向真实世界  |
| 错误代价低       | 错误代价高   |



## 2. VLA 为什么出现

传统机器人长期存在几个根本问题。


### 1. 强依赖规则编程

传统工业机器人，每个动作手工编程，例如，固定轨迹、固定夹具、固定环境。

存在的问题是环境稍有变化，系统失效，缺乏泛化能力。


### 2. 感知与控制割裂

传统机器人：

```text id="4kk4rp"
视觉系统
↓
目标检测
↓
坐标转换
↓
运动规划
↓
控制器
```

是多个独立模块拼接。

导致：

* 系统复杂
* 误差累积
* 难以维护
* 泛化差



### 3. 缺乏语义理解

传统机器人不理解：

```text id="s5hh4u"
“帮我整理桌子”
```

因为它只懂坐标、轨迹、夹爪，不理解任务目标、语义逻辑、世界知识。



### 4. 无法处理开放世界

真实世界不是工厂流水线。

存在：

* 遮挡
* 光照变化
* 未知物体
* 动态环境
* 人机协同

传统方法难以扩展。

---

## 3. VLA 的核心思想

VLA 的关键突破：“把视觉、语言、动作统一成同一种 token 序列”。 即：

```text id="juy4kt"
Image Tokens
Text Tokens
Action Tokens
```

全部送入 Transformer。

于是, 机器人可以像生成文字一样 “生成动作”。这也是为什么 **Transformer 成为 VLA 的核心架构**。

---

## 4. VLA 的技术架构

典型 VLA 系统：

```text id="mfr03s"
Camera / Sensor
        ↓
Vision Encoder
        ↓
Visual Tokens
        ↓
Multimodal Transformer
        ↓
Action Tokens
        ↓
Robot Controller
        ↓
Motor / Actuator
```

其本质是 **“从感知到动作的端到端序列生成”**。

---

## 5. VLA 的关键技术模块


### 1. Vision Encoder（视觉编码）

目标：图像 → Token。

典型模型：

* ViT
* DINOv2
* SigLIP
* EVA

方法：图像切分为 patch, 例如：

```text id="kt1a2k"
224×224 图像
↓
16×16 patch
↓
196 patches
```

设 图像$I \in R^{H\times W\times C}$，Patch embedding $x_i = W_p \cdot patch_i + b$， 得到$X=[x_1,x_2,...,x_n]$，形成视觉 token 序列。



### 2. 多模态 Transformer

这是 VLA 的“大脑”。

输入：

```text id="0flnmk"
视觉 token
文本 token
动作 token
```

统一建模，Transformer 学习：

* 世界状态
* 空间关系
* 动作关联
* 长时序任务

核心机制是Attention。



#### Attention 数学

$$\operatorname{Attention}(Q,K,V)=\operatorname{softmax}\left(\frac{QK^T}{\sqrt{d}}\right)V$$

本质是模型自动决定 “当前动作应该关注哪里”。

例如：

```text id="u4i0ya"
“拿起红色杯子”
```

Attention 自动聚焦：

* 红色区域
* 杯子边缘
* 手部位置



### 3. Action Tokenization（动作 Token 化）

这是 VLA 的核心难点之一。

机器人动作原本是连续值：

```text id="pcx79h"
(x,y,z,roll,pitch,yaw,gripper)
```

Transformer 更擅长离散 token。因此，动作需要 token 化。


#### 离散化方法

设动作：$a \in [-1,1]$

量化：$a_q = \operatorname{round}\left(\frac{a-a_{min}}{a_{max}-a_{min}}\times255\right)$

得到256 个动作 bin，于是，动作变成 **Action Tokens**。 Transformer 可以像生成文本一样生成动作。



## 6. VLA 的核心数学建模


### 1. 序列生成模型

VLA 本质是条件概率序列生成。

目标：$P(a_1,a_2,...,a_T \mid V,L)$

自回归展开：$P(A)=\prod_t P(a_t|a_{<t},V,L)$, 即当前动作依赖 当前视觉、当前任务、历史动作。


### 2. 行为克隆（Behavior Cloning）

模仿学习是最常见训练方式，即：

```text id="uq24ph"
人类演示
→
机器人学习
```

损失函数：$\mathcal{L}=-\sum_t \log P(a_t^*\mid V,L,a_{<t})$

目标：让机器人模仿专家行为。



### 3. 强化学习（RL）

进一步优化， 机器人通过试错，学习长期收益最大化。

目标函数：$J(\theta)=\mathbb{E}*{\pi*\theta}\left[\sum_t \gamma^t r_t\right]$

用于：

* 长时序任务
* 自主探索
* 策略优化


### 4. 世界模型（World Model）

更高级 VLA，不只是生成动作，而是预测未来世界。即：$P(S_{t+1}\mid S_t,A_t)$。本质是机器人内部的“物理模拟器”。

---

## 7. VLA 解决的核心问题


### 1. 通用任务泛化

过去每个任务单独开发。

VLA：

目标：

```text id="3y4q0j"
一个模型
多种任务
```

例如同一个机器人 抓取、整理、分拣、搬运，统一完成。



### 2. 自然语言交互

用户直接说：

```text id="ty1cbv"
“把桌子整理干净”
```

机器人理解：

* “桌子”
* “杂乱”
* “归位”

不再需要传统编程。


### 3. 开放环境适应

VLA 能处理 新物体、新环境、新任务。具备零样本泛化能力。


### 4. 感知与控制统一

过去CV 与控制分离，现在统一学习：

```text id="6ppzkd"
感知 → 推理 → 动作
```

形成闭环。

---

## 8. VLA 的主要挑战


### 1. 数据极度稀缺

GPT：互联网文本无限。

VLA：每条数据都是真实物理动作，成本极高。

例如 遥操作采集、人工标注、机器人磨损，因此，机器人数据远比文本数据昂贵。


### 2. Sim2Real（仿真到现实）

仿真成功，现实失败。

因为现实世界存在 摩擦、光照、形变、噪声、遮挡，导致仿真与现实不一致。这是机器人几十年的核心难题。


### 3. 动作空间巨大

人形机器人可能：$30\sim100+ DoF$，若每个自由度256 离散值。动作组合：256^{30}+。组合空间爆炸。


### 4. 实时性问题

机器人控制通常要求时延 10Hz~500Hz，而Transformer推理耗时大。

因此当前普遍采用：VLA 高层规划 + 传统控制器低层执行。



### 5. 长尾问题

真实世界无限复杂。

例如 透明物体、黑色反光、柔性物体、液体，都是当前巨大挑战。


### 6. 物理一致性问题

LLM 可以胡说，但机器人不能。

错误动作可能 摔倒、撞人、损坏设备，因此VLA 必须满足动力学约束：$M(q)\ddot q + C(q,\dot q)\dot q + g(q)=\tau$，但 Transformer 天生不理解物理规律。

---

## 9. VLA 的典型应用场景


### 1. 人形机器人

代表：

* Tesla Optimus
* Figure AI
* Agility Robotics

应用：

* 家务
* 工厂
* 仓储
* 服务



### 2. 工业自动化

VLA 能显著提升：

* 柔性制造
* 小批量生产
* 自适应抓取

尤其适合工业视觉与 AI 自动化方向。


### 3. 自动驾驶

自动驾驶本质也是 VLA。即：

```text id="q2w3cm"
视觉输入
↓
世界理解
↓
驾驶动作
```


### 4. 医疗机器人

包括：

* 手术辅助
* 康复
* 护理



### 5. 智能仓储

例如：

* Picking
* Packing
* 多机器人协同

---

## 10. VLA 的未来方向


### 1. World Model

机器人先“想象未来”再行动。这是未来最关键方向。



### 2. Diffusion Policy

直接生成连续动作轨迹。比 token 化更平滑稳定。


### 3. Hierarchical VLA

分层控制：

```text id="5rk5q6"
任务规划
↓
技能规划
↓
运动控制
```

类似人脑结构。



### 4. Self-Improving Robot

机器人自主学习，观察、尝试、失败、修正，长期可能形成 **“机器人互联网经验库”**。

---

## 11. VLA 技术总结

#### VLA 的本质

> VLA 是一种统一视觉、语言与动作的概率生成模型，通过学习“世界状态 → 动作轨迹”的映射，让机器人获得通用物理交互能力。

#### VLA 的核心意义

它意味着 **AI 正从“信息智能”进入“物理智能”**。

过去AI处理，文本、图像、语音；未来 AI开始真正 “操作现实世界”。 这是 AI 历史上的关键跃迁。


#### 当前 VLA 的真实阶段

目前VLA 仍处于“早期 GPT 时代”，已经展示巨大潜力。但距离“真正通用机器人” 仍有巨大距离。真正缺失的不是更大的模型，而是 **“真正理解物理世界运行规律的世界模型”**。
