# **中国主流开源大模型（LLM）的对比分析**

author: 周均扬

date： 2026.05.16

---

给出中国主流开源大模型（LLM）的对比分析，重点从 **开源程度** 、 **许可证（License）与商业友好度** 这两个维度展开梳理，并列出代表性模型及其特点([1])。


## 1. 开源程度

这里对“开源程度”做一个工程实践上的划分：

* **全开源（完全开放）**：公开 *权重 + 源代码 + 商业友好许可证*；可自托管、自由改造。
* **开放权重**：仅权重可下载，但源代码/训练数据未全部公开，或部分采用社区/产品条款。
* **受限开放/研究用途**：可用于研究，商业使用受到条件约束。([2])

### 1) DeepSeek 系列（DeepSeek‑R1 / V3 / V4 等）

* **开源程度**：**高**

  * 模型权重公开，可自托管和本地推理。
  * 多数版本源码可访问，没有黑盒 API 依赖。([3])
* **许可证**：**MIT（宽松、商业友好）**

  * 允许复制、修改、商业用途；
  * 无附加收入/使用约束（典型 MIT）。([4])
* **优点**：真正开源、无商业绑定；适合企业/产品级部署。
* **短板**：生态社区相对国际模型略小。([3])


### 2) 阿里巴巴 Qwen（通义千问） 系列

* **开源程度**：

  * **Qwen‑2.5 系列**：主流尺寸权重 + 代码公开，可本地部署。
  * **部分早期 Qwen 版本**：曾采用定制社区许可（需要注意具体版本许可条款）。([5])
* **许可证**：

  * 近年来主要以 **Apache 2.0（宽松）** 发布（例如 Qwen2.5 多数版本）。([4])
  * 部分大模型仍使用 **Tongyi Qianwen License Agreement**（限制条款更细，特别在大模型使用上需检查条款）([5])
* **商业友好度**：

  * Apache 2.0 允许商业用途、二次分发，企业产品级部署友好。
  * 需特别阅读 Qwen 特定大型模型的许可或产品条款限制。([5])


### 3) 知谱 AI / GLM 系列（ChatGLM / GLM‑4.x / GLM‑5）

* **开源程度**：

  * 多数模型权重公开并可本地部署，自由度高。
* **许可证**：

  * 多数模型转向 **MIT 或 Apache‑style 许可**，商业使用友好。([4])
* **评估**：

  * GLM 在中文理解、上下文能力上表现强；
  * 许可从早期社区协议逐步走向宽松。([4])


### 4) 其他中国模型（如 Kimi / Baidu ERNIE / MiniMax 等）

* Kimi（如 Moonshot AI 的 Kimi K2.5 系列）部分在 Hugging Face 发布权重，但许可类型可能仍是平台服务条款式（需详细阅读）。([5])
* 百度部分旗舰模型如 ERNIE 也转向开放权重（但更侧重 API + 产品生态）。([6])

---

## 2. 许可证与商业友好度

| 模型族群                                   | 典型许可证               | 商业友好程度 | 评论                            |
| -------------------------------------- | ------------------- | ------ | ----------------------------- |
| **DeepSeek (MIT)**                     | **MIT**             | ⭐⭐⭐⭐   | 最宽松的开源许可；无商业或使用门槛限制           |
| **Qwen 系列（Apache 2.0 / Qwen License）** | Apache 2.0 / 定制协议   | ⭐⭐⭐    | Apache 2.0 商用友好；定制协议版本需注意使用条款 |
| **GLM / ChatGLM 系列**                   | 常见 MIT / Apache 2.0 | ⭐⭐⭐⭐   | 转向 MIT/Apache 2.0 提升友好性       |
| **Kimi 系列**                            | 多为服务/平台条款           | ⭐⭐     | 商用部署需审查具体条款                   |
| **部分早期中国模型**                           | 研究/社区协议             | ⭐★     | 存在商用或用途限制（需进一步协议审查）           |

**说明**：

* **MIT & Apache 2.0** 都是行业认可的宽松商业许可（允许修改、分发、集成于商业产品）。([7])
* **自定义许可（如部分 Qwen License /平台服务条款）** 可能包含商业使用、月活用户限制等条款，需仔细阅读。([5])

---

## 3. 典型模型总结

### 📌 代表性中国开源 LLM 一览（2026）

| 名称                        | 开源权重 | 源代码 | 典型许可            | 商业友好  | 备注           |
| ------------------------- | ---- | --- | --------------- | ----- | ------------ |
| **DeepSeek‑R1 / V4**      | ✅    | ✅   | MIT             | ⭐⭐⭐⭐  | 完全开源、商业灵活    |
| **Qwen2.5 / Qwen3 系列**    | ✅    | 可   | Apache 2.0 / 混合 | ⭐⭐⭐   | 主流中文版支持强     |
| **ChatGLM / GLM‑4.x/5.x** | ✅    | 可   | Apache/MIT      | ⭐⭐⭐⭐  | 中文语义表现好      |
| **Kimi 系列**               | ✅    | 否*  | 平台条款            | ⭐⭐    | 注意具体条款限制     |
| **Baidu ERNIE**           | 可公布  | 视版本 | 混合              | ⭐⭐~⭐⭐ | 趋向开放但生态偏大厂产品 |

*注：某些模型的“源代码可用”指公开推理接口/示例、训练脚本等，但不是全面训练环境。([5])

---

## 4. 实践建议

### 🧩 选择模型时重点考量维度

1. **许可证合法性**

   * 优先选 MIT / Apache 2.0 等真正宽松的开源许可；
   * 自定义许可需审查是否限制用途、收入、地域等。([4])

2. **部署模型类型**

   * 自托管/本地推理优先推荐 DeepSeek / Apache‑licensed Qwen / GLM；
   * 平台 API 可选但需注意服务条款。([1])

3. **生态成熟度**

   * DeepSeek、Qwen 生态社区和工具链活跃，便于二次开发；
   * GLM 的中文优化对中文业务非常友好。([3])

---

## 5. 结论

* **中国主流开源大模型整体呈现“开放权重 + 商业友好许可”趋势**，典型的 MIT 或 Apache‑style 许可证在 2025–2026 年成为主流。([4])
* **DeepSeek 系列凭借 MIT 许可在商业友好度上最为突出**，适合企业级部署。
* **Qwen 和 GLM 系列** 多使用 Apache 2.0，风险相对低，适合产品集成。
* **部分自定义许可模型需额外审查条款**，不能简单地认为“公开权重 = 完全开源”。([7])

参考资料： 

[1]: https://inferencehub.org/blog/chinese-frontier-open-source-ai-models-2026/?utm_source=chatgpt.com "Chinese Frontier Open-Source AI Models in 2026: The Labs, the Models, and How They Stack Up | Inference Hub"

[2]: https://llmguides.ai/models/open-source-llms/?utm_source=chatgpt.com "Open-Source LLMs Explained - LLM Guides"

[3]: https://www.index.dev/blog/chinese-open-source-llms?utm_source=chatgpt.com "Top 5 Chinese Open-Source LLMs to Watch in 2025"

[4]: https://quant67.com/post/opensource/24-model-license/model-license.html?utm_source=chatgpt.com "【开源许可与版权工程】模型许可证深度解析：OpenRAIL-M、LLaMA"

[5]: https://help.arena.ai/articles/4171906875-model_licenses?utm_source=chatgpt.com "Model Licenses - Arena Help Center"

[6]: https://intuitionlabs.ai/articles/chinese-open-source-llms-2025?utm_source=chatgpt.com "An Overview of Chinese Open-Source LLMs (Sept 2025)"

[7]: https://www.simplilearn.com/open-source-llms-article?utm_source=chatgpt.com "Top Open Source LLMs (2026): Benchmarks and Licenses"
