// Upload Image
const fileInput = document.getElementById("file-upload");
const uploadText = document.getElementById("upload");
// menambahkan event change setelah ada update dari user
fileInput.addEventListener("change", function () {
  // jika ada file yang diupload maka hidden upload text
  if (fileInput.files.length > 0) {
    uploadText.classList.add("hidden");
    // remove opacity di input file
    fileInput.classList.remove("opacity-0");
    // setter value jadi file name
    fileInput.setAttribute("value", fileInput.files[0].name);
  }
  // jika tidak ada file di upload maka jalankan perintah function resetUpload()
  else {
    resetUpload();
  }
});
function resetUpload() {
  uploadText.classList.remove("hidden");
  fileInput.classList.add("opacity-0");
  fileInput.setAttribute("value", "");
}
fileInput.addEventListener("input", function () {
  if (!fileInput.files.length) resetUpload();
});
