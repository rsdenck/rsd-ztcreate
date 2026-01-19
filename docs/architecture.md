# Arquitetura do Sistema - RSD ZT CREATE

Este documento descreve a arquitetura interna do **RSD ZT CREATE**, focando na modularidade, escalabilidade e no novo motor de geração de templates a partir de APIs.

## 🏗️ Estrutura Geral

A aplicação segue o padrão **Service-Builder**, separando a lógica de negócio (análise de dados) da lógica de construção do objeto final (Template Zabbix).

---

## 🚀 Nova Camada: API Template Generator

Esta camada é responsável por analisar APIs externas (REST, SOAP, GraphQL) e transformá-las automaticamente em templates Zabbix otimizados, utilizando massivamente **Low Level Discovery (LLD)** e **HTTP Agent**.

### 🛠️ Componentes Principais

#### 1. Services (`/app/Services/Api`)
- **ApiAnalyzerService**: Analisa a resposta da API (JSON/XML) para identificar estruturas de dados, tipos de métricas e entidades repetitivas.
- **ApiDiscoveryService**: Identifica listas e objetos que podem ser transformados em Regras de Descoberta (LLD).
- **ApiAuthService**: Gerencia a configuração de autenticação (API Key, OAuth2, Bearer, etc.) de forma segura.

#### 2. Builders (`/app/Builders/Api`)
- **ApiTemplateBuilder**: Orquestra a criação do template, integrando macros, tags e regras.
- **ApiLldBuilder**: Constrói as regras de descoberta baseadas nos endpoints analisados.
- **ApiItemPrototypeBuilder**: Cria protótipos de itens com pré-processamento (JSONPath/XPath) automático.
- **ApiTriggerPrototypeBuilder**: Gera gatilhos inteligentes baseados em latência, erros e status de saúde da API.

#### 3. Models (`/app/Models`)
- **ApiDefinition**: Armazena a URL base, tipo de API e metadados gerais.
- **ApiEndpoint**: Define o caminho, método HTTP, payload e intervalos de coleta.
- **ApiAuthConfig**: Configurações de segurança e autenticação para os itens do tipo HTTP Agent.

#### 4. Exporters (`/app/Exporters`)
- **ZabbixApiTemplateExporter**: Transforma os modelos internos em uma estrutura JSON 100% compatível com as versões 6.x e 7.x do Zabbix.

---

## 📊 Diagrama Lógico (Texto)

```text
[ UI: Wizard Step ] 
       │
       ▼
[ Controller: WizardController ] ──▶ [ Service: ApiTemplateGeneratorService ]
       │                                     │
       │                                     ├─▶ [ Service: ApiAnalyzerService ]
       │                                     ├─▶ [ Service: ApiDiscoveryService ]
       │                                     └─▶ [ Service: ApiAuthService ]
       │                                             │
       ▼                                             ▼
[ Models: ApiDefinition ] ◀─────── [ Builders: ApiTemplateBuilder ]
[ Models: ApiEndpoint   ] ◀─────── [ Builders: ApiLldBuilder      ]
[ Models: ApiAuthConfig ] ◀─────── [ Builders: ApiItemPrototypeBuilder ]
       │                                     └─▶ [ Builders: ApiTriggerPrototypeBuilder ]
       │
       ▼
[ Models: Template (Object Graph) ]
       │
       ▼
[ Exporter: ZabbixApiTemplateExporter ] ──▶ [ ExportService ] ──▶ [ JSON FINAL ]
```

---

1. **Input**: O usuário fornece a URL Base, Tipo de API e Credenciais.
2. **Analysis**: O `ApiAnalyzerService` faz requisições de teste para os endpoints informados.
3. **Detection**: O sistema identifica listas (ex: `/v1/sensors`) e mapeia campos (ex: `id`, `value`, `unit`).
4. **Generation**:
   - Criação de **LLD Macros** dinâmicas (ex: `{#SENSOR_ID}`).
   - Criação de **Item Prototypes** com pré-processamento JSONPath (ex: `$.[?(@.id == "{#SENSOR_ID}")].value`).
   - Configuração de **Tags** automáticas por vendor e endpoint.
5. **Export**: O usuário baixa o JSON pronto para importação.

---

## 📝 Exemplos de Geração

### Exemplo REST LLD
**API**: `https://api.exemplo.com/v1/disks`
**JSON Gerado**: `[{"id": "sda", "used": 40}, {"id": "sdb", "used": 80}]`
**LLD Gerado**:
- Regra: `Discover Disks`
- Item Prototype: `Disk used percentage for {#ID}`
- JSONPath: `$.[?(@.id == "{#ID}")].used`

### Exemplo SOAP (XML)
**API**: `https://api.exemplo.com/Service.asmx`
**XPath Gerado**: `//Status/text()`

### Exemplo GraphQL
**Endpoint**: `/graphql`
**Query**: `{ devices { id name status } }`

---

## 🛡️ Padrões e Segurança
- **Builder Pattern**: Garante flexibilidade para adicionar novos tipos de exportação no futuro.
- **SOLID**: Componentes desacoplados facilitam a manutenção.
- **Segurança**: Credenciais sensíveis são tratadas como macros secretas ou variáveis de ambiente, nunca exportadas em texto plano se configurado pelo usuário.

---

## ⚡ Trigger Creator (Inteligente)

Esta feature permite a criação de gatilhos (triggers) Zabbix de forma assistida, eliminando a necessidade de escrever expressões complexas manualmente. Suporta triggers regulares, de recuperação e protótipos de LLD.

### 🛠️ Componentes Principais

#### 1. Services (`/app/Services/Trigger`)
- **TriggerValidatorService**: Valida a sintaxe da expressão, existência de itens e compatibilidade de tipos.
- **TriggerExpressionBuilderService**: Converte seleções da UI (funções, operadores, thresholds) em expressões Zabbix válidas.
- **TriggerDependencyService**: Gerencia relacionamentos de dependência entre triggers para evitar loops e alertas redundantes.

#### 2. Builders (`/app/Builders/Trigger`)
- **TriggerBuilder**: Constrói o objeto Trigger padrão.
- **TriggerPrototypeBuilder**: Constrói protótipos de trigger para Regras de Descoberta (LLD).
- **TriggerRecoveryBuilder**: Focado na construção de `recovery_expressions` complexas.

#### 3. Models (`/app/Models`)
- **TriggerDefinition**: Metadados do trigger (nome, severidade, descrição).
- **TriggerExpression**: Fragmentos de expressões encadeadas.
- **TriggerFunction**: Mapeamento de funções Zabbix (last, avg, count, etc).
- **TriggerDependency**: Relacionamento N:N para dependências.
- **TriggerTag**: Tags específicas aplicadas ao trigger.

#### 4. Exporters (`/app/Exporters`)
- **ZabbixTriggerExporter**: Especializado na serialização de triggers para o formato JSON Zabbix.

### 🔄 Fluxo de Criação

1. **Seleção de Itens**: O usuário escolhe um ou mais itens (ou protótipos).
2. **Configuração de Função**: Escolha da função Zabbix (ex: `last()`) e parâmetros.
3. **Definição de Threshold**: Operadores (>, <, =) e valores (macros ou constantes).
4. **Severidade**: Definição do nível de criticidade (Information a Disaster).
5. **Recuperação (Opcional)**: Configuração de expressão de fechamento automático.
6. **Dependências & Tags**: Ajustes finais de comportamento e organização.

### 📝 Exemplos de Triggers

#### Trigger Simples (High CPU)
- **Expressão**: `last(/Template/system.cpu.util) > {$CPU.MAX}`
- **Severidade**: Warning

#### Trigger Prototype (LLD Disk Space)
- **Expressão**: `last(/Template/vfs.fs.size[{#FSNAME},pused]) > 90`
- **Severidade**: High

#### Recovery Expression (Hysteresis)
- **Problem**: `avg(/Template/sensor.temp,5m) > 40`
- **Recovery**: `avg(/Template/sensor.temp,5m) < 35`

