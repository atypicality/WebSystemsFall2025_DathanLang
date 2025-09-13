window.addEventListener('scroll', function() {
    const scrollY = window.scrollY;
    const parallax = document.getElementById('parallax');
    const speed = 0.25;
    parallax.style.transform = `translateY(${scrollY * speed}px)`;
  });