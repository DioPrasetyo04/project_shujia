document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab-button");
  const tabContents = document.getElementById("tabs-content-container");

  tabs.forEach((button) => {
    button.addEventListener("click", function () {
      tabContents.querySelectorAll(".tab-content").forEach((tabContent) => {
        tabContent.classList.add("hidden");
      });

      const targetId = button.getAttribute("data-target");
      document.getElementById(targetId).classList.remove("hidden");
    });
  });
});
