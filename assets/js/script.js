const verSenha = document.getElementById("floatingPassword")
const olhoFechado = document.getElementsByClassName("bi-eye-slash")
const olhoAberto = document.getElementsByClassName("bi-eye")

olhoFechado.onclick = function () {
    olhoFechado.style.display = "none"
    olhoAberto.style.display = "block"
}

olhoAberto.onclick = function () {
    olhoAberto.style.display = "none"
    olhoFechado.style.display = "block"
}

