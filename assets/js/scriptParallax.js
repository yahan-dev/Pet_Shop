const parallaxElements = document.querySelectorAll('.parallax');

document.addEventListener('mousemove', (e) => {
  const { clientX: mouseX, clientY: mouseY } = e;
  const centerX = window.innerWidth / 1;
  const centerY = window.innerHeight / 1;

  parallaxElements.forEach((element, index) => {
    const strengthX = (index + 1) * 2; // Adjust strength multiplier for X direction
    const strengthY = (index + 1) * 2; // Adjust strength multiplier for Y direction

    const offsetX = (mouseX - centerX) * strengthX / centerX;
    const offsetY = (mouseY - centerY) * strengthY / centerY;

    // Modify transform to apply different directions
    if (index % 2 === 0) {
      element.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
    } else {
      element.style.transform = `translate(${-offsetX}px, ${-offsetY}px)`;
    }
  });
});
