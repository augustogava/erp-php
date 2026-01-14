function busca_cep(cep) {
  try {
    const raw = String(cep || "");
    const onlyDigits = raw.replace(/\D+/g, "");
    if (onlyDigits.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${onlyDigits}/json/`, { cache: "no-store" })
      .then((r) => r.json())
      .then((data) => {
        if (!data || data.erro) {
          console.warn("CEP_LOOKUP_NOT_FOUND_log");
          return;
        }

        const endereco = document.getElementById("endereco");
        const bairro = document.getElementById("bairro");
        const cidade = document.getElementById("cidade");
        const estado = document.getElementById("estado");

        if (endereco && data.logradouro) endereco.value = data.logradouro;
        if (bairro && data.bairro) bairro.value = data.bairro;
        if (cidade && data.localidade) cidade.value = data.localidade;
        if (estado && data.uf) estado.value = data.uf;
      })
      .catch((e) => {
        console.error("CEP_LOOKUP_ERROR_log", e);
      });
  } catch (e) {
    console.error("CEP_LOOKUP_ERROR_log", e);
  }
}
