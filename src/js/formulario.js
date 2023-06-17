console.log('JS - Formulário')

function cpfFormatar() {
  const campo = event.currentTarget

  let cpf = campo.value
  cpf = cpf.replace(/\D/g, '')
  cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2')
  cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2')
  cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2')

  campo.value = cpf
}


function cnpjFormatar() {
  const campo = event.currentTarget

  let cnpj = campo.value
  cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2')
  cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
  cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2')
  cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2')

  campo.value = cnpj
}


function cepFormatar() {
  const campo = event.currentTarget

  let cep = campo.value
  cep = cep.replace(/\D/g, '')
  cep = cep.replace(/(\d{5})(\d)/, '$1-$2')

  campo.value = cep
}


function celularFormatar() {
  const campo = event.currentTarget

  let celular = campo.value
  celular = celular.replace(/\D/g, '')
  celular = celular.replace(/^(\d{2})(\d)/g, '($1)$2')
  celular = celular.replace(/(\d{5})(\d)/, '$1-$2')
  celular = celular.replace(/(\d{4})(\d)/, '$1$2')

  campo.value = celular
}