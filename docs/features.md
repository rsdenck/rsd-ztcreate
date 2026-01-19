# Funcionalidades e Guia de Uso

O **RSD ZT CREATE** foi projetado para simplificar a criação de templates complexos do Zabbix através de uma interface visual intuitiva.

## 🚀 Funcionalidades Detalhadas

### 1. Gestão de Metadados
Permite definir a identidade do seu template. Você pode especificar o fornecedor (Vendor) e a versão, o que é crucial para templates distribuídos na comunidade.

### 2. Macros e Tags Dinâmicas
- **Macros:** Defina variáveis globais como `{$URL}`, `{$USER}` ou `{$PORT}` que podem ser usadas em qualquer lugar do template.
- **Tags:** Organize seus hosts e itens logicamente para facilitar a filtragem no dashboard do Zabbix.

### 3. Itens e Coleta de Dados
Suporte a diversos tipos de itens:
- **Zabbix Agent:** Coleta padrão via agente.
- **HTTP Agent:** Coleta de dados via APIs JSON/XML.
- **SNMP:** Monitoramento de ativos de rede (necessita OID).

### 4. Low Level Discovery (LLD)
A funcionalidade mais poderosa para automação.
- **Regras de Descoberta:** Varre o sistema em busca de recursos (discos, interfaces, containers).
- **Protótipos de Itens:** Define o que monitorar para cada recurso descoberto automaticamente.

### 5. Gatilhos (Triggers)
Configure alertas baseados em funções do Zabbix:
- `last()`, `avg()`, `min()`, `max()`.
- Níveis de severidade: Info, Warning, Average, High, Disaster.

### 6. Web Scenarios (HTTP Tests)
Simule a jornada do usuário em sua aplicação:
- Verificação de status code (ex: 200 OK).
- Verificação de strings na página.
- Múltiplos passos com dependências.

---

## 📖 Como Usar a Aplicação

1. **Início:** Na página inicial, clique em "Começar Wizard".
2. **Passo 1 (Geral):** Preencha o nome do template e escolha a versão do seu Zabbix.
3. **Passo 2 (Macros/Tags):** Adicione as macros que seu template irá precisar.
4. **Passo 3 (Itens):** Defina os itens básicos de monitoramento.
5. **Passo 4 (LLD):** Se precisar de descoberta automática, configure aqui sua regra e os protótipos.
6. **Passo 5 (Triggers):** Defina quando o Zabbix deve disparar um alerta.
7. **Passo 6 (Web Scenarios):** Configure testes de URL se for uma aplicação web.
8. **Finalização:** Revise o resumo e clique em "Baixar Template JSON".
9. **Zabbix:** Vá em *Data Collection -> Templates -> Import* no seu Zabbix e envie o arquivo gerado.
