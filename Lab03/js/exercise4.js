document.addEventListener("DOMContentLoaded", function () {
  const imageList = document.getElementById("imageList");
  const imgElement = document.querySelector("img");
  const backButton = document.querySelector("button:nth-of-type(1)");
  const startSlideshowButton = document.querySelector("button:nth-of-type(2)");
  const nextButton = document.querySelector("button:nth-of-type(3)");
  const imageInfo = document.querySelector("p");

  let currentImageIndex = 0;
  let slideshowInterval;
  const imageName = imageList.options[currentImageIndex].value;
  imgElement.src = "images/" + imageName;

  function updateImage() {
    const imageName = imageList.options[currentImageIndex].value;
    imgElement.src = "images/" + imageName;
    imageInfo.textContent =
      imageName +
      " (" +
      (currentImageIndex + 1) +
      "/" +
      imageList.options.length +
      ")";
  }

  function nextImage() {
    currentImageIndex++;
    if (currentImageIndex >= imageList.options.length) {
      currentImageIndex = 0;
    }
    updateImage();
  }

  function prevImage() {
    currentImageIndex--;
    if (currentImageIndex < 0) {
      currentImageIndex = imageList.options.length - 1;
    }
    updateImage();
  }

  function startSlideshow() {
    slideshowInterval = setInterval(nextImage, 1000);
    nextButton.disabled = true;
    backButton.disabled = true;
    startSlideshowButton.textContent = "Stop slideshow";
    startSlideshowButton.removeEventListener("click", startSlideshow);
    startSlideshowButton.addEventListener("click", stopSlideshow);
  }

  function stopSlideshow() {
    clearInterval(slideshowInterval);
    nextButton.disabled = false;
    backButton.disabled = false;
    startSlideshowButton.textContent = "Start slideshow";
    startSlideshowButton.removeEventListener("click", stopSlideshow);
    startSlideshowButton.addEventListener("click", startSlideshow);
  }

  nextButton.addEventListener("click", nextImage);
  backButton.addEventListener("click", prevImage);
  startSlideshowButton.addEventListener("click", startSlideshow);
  updateImage();
});
