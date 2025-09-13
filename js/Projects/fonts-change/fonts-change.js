document.addEventListener("DOMContentLoaded", function () {
  const button1 = document.getElementById("btn1");
  const button2 = document.getElementById("btn2");
  const button3 = document.getElementById("btn3");
  const button4 = document.getElementById("btn4");
  const textP = document.getElementById("text-show-p");
  const textInput = document.getElementById("font-show");

  textInput.addEventListener("input", (e) => {
    textP.textContent = e.target.value;
    if (textP.textContent === "") {
      textP.textContent = `"Начните вводить что-то чтоб посмотреть"`;
    }
  });

  button1.addEventListener("click", () => {
    textP.style.fontFamily = "Caveat";
  });
  button2.addEventListener("click", () => {
    textP.style.fontFamily = "Montserrat";
  });
  button3.addEventListener("click", () => {
    textP.style.fontFamily = "Bitcount Grid Double";
  });
  button4.addEventListener("click", () => {
    textP.style.fontFamily = "Playfair Display";
  });
});
