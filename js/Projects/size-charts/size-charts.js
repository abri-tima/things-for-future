import { chestInterval, hipInterval, stretchInterval } from "./sizeInterval.js";
import {
  chestIntervalUsa,
  hipIntervalUsa,
  stretchIntervalUsa,
} from "./usa-size-chart.js";

document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".btn-item-chart");
  const buttonsType = document.querySelectorAll(".btn-item-size-type");
  const chestText = document.getElementById("chestInter");
  const hipText = document.getElementById("hipInter");
  const stretchText = document.getElementById("stretchInter");

  let currentSizeValue = "S";
  let currentType = "Cm";

  let minChest = "";
  let maxChest = "";
  let minHip = "";
  let maxHip = "";
  let stretchVal = "";
  let minChestUsa = "";
  let maxChestUsa = "";
  let minHipUsa = "";
  let maxHipUsa = "";
  let stretchValUsa = "";

  function updateDisplay(type, size) {
    if (type === "Cm") {
      const chestInt = chestInterval.find((chs) => chs.size === size);
      const hipInt = hipInterval.find((hp) => hp.size === size);
      const stretchInt = stretchInterval.find((str) => str.size === size);

      if (chestInt && hipInt && stretchInt) {
        minChest = chestInt.min.toString();
        maxChest = chestInt.max.toString();
        minHip = hipInt.min.toString();
        maxHip = hipInt.max.toString();
        stretchVal = stretchInt.stretch;

        chestText.textContent = `${minChest} - ${maxChest}`;
        hipText.textContent = `${minHip} - ${maxHip}`;
        stretchText.textContent = `${stretchVal}`;
      }
    } else if (type === "Ft") {
      const chestIntUsa = chestIntervalUsa.find(
        (chsu) => chsu.size === size
      );
      const hipIntUsa = hipIntervalUsa.find((hpu) => hpu.size === size);
      const stretchIntUsa = stretchIntervalUsa.find(
        (stru) => stru.size === size
      );

      if (chestIntUsa && hipIntUsa && stretchIntUsa) {
        minChestUsa = chestIntUsa.min.toString();
        maxChestUsa = chestIntUsa.max.toString();
        minHipUsa = hipIntUsa.min.toString();
        maxHipUsa = hipIntUsa.max.toString();
        stretchValUsa = stretchIntUsa.stretch;
        console.log(
          "usa:",
          minChestUsa,
          maxChestUsa,
          minHipUsa,
          maxHipUsa,
          stretchValUsa
        );

        chestText.textContent = `${minChestUsa} - ${maxChestUsa}`;
        hipText.textContent = `${minHipUsa} - ${maxHipUsa}`;
        stretchText.textContent = `${stretchValUsa}`;
      }
    }
  }

  // Функция для кнопок размеров (S/M/L/XL/XXL)
  function handleButtonClick(button) {
    buttons.forEach((btn) => btn.classList.remove("btn-chart-active"));
    button.classList.add("btn-chart-active");

    currentSizeValue = button.value;
    updateDisplay(currentType, currentSizeValue);
  }

  // Функция для кнопкок типа размеров (Cm/Ft)
  function handleButtonClickType(button) {
    buttonsType.forEach((btn) =>
      btn.classList.remove("btn-item-size-type-active")
    );
    button.classList.add("btn-item-size-type-active");

    currentType = button.value;
    updateDisplay(currentType, currentSizeValue);
  }

  // обработчики кнопок
  buttonsType.forEach((btn) => {
    btn.addEventListener("click", () => handleButtonClickType(btn));
  });

  buttons.forEach((button) => {
    button.addEventListener("click", () => handleButtonClick(button));
  });


  // Выставление кнопко по умолчанию
  const baseBtn = Array.from(buttons).find(
    (btn) => btn.value === currentSizeValue
  );
  if (baseBtn) {
    handleButtonClick(baseBtn);
  }

  const baseBtnType = Array.from(buttonsType).find(
    (btn) => btn.value === currentType
  );
  if (baseBtnType) {
    handleButtonClickType(baseBtnType);
  }
});
