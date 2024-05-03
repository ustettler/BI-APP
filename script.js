// Wert Animation
window.addEventListener('DOMContentLoaded', () => {
    const kwhElement = document.getElementById('kwh');
    const targetValue = parseInt(kwhElement.textContent); // Hole den Startwert
  
    let currentValue = 0; // Startwert für Animation
    const duration = 2000; // Dauer der Animation in Millisekunden
    const frameDuration = 1000 / 60; // Annahme von 60 FPS
  
    const totalFrames = Math.round(duration / frameDuration);
    const increment = targetValue / totalFrames;
  
    const animateValue = () => {
      currentValue += increment;
      kwhElement.textContent = currentValue.toFixed(2); // Auf zwei Dezimalstellen runden
      if (currentValue < targetValue) {
        requestAnimationFrame(animateValue);
      } else {
        kwhElement.textContent = targetValue.toFixed(2);
      }
    };
  
    animateValue();
  });

  // Wert Animation
window.addEventListener('DOMContentLoaded', () => {
  const kwhElement = document.getElementById('kwh-week');
  const targetValue = parseInt(kwhElement.textContent); // Hole den Startwert

  let currentValue = 0; // Startwert für Animation
  const duration = 2000; // Dauer der Animation in Millisekunden
  const frameDuration = 1000 / 60; // Annahme von 60 FPS

  const totalFrames = Math.round(duration / frameDuration);
  const increment = targetValue / totalFrames;

  const animateValue = () => {
    currentValue += increment;
    kwhElement.textContent = currentValue.toFixed(2); // Auf zwei Dezimalstellen runden
    if (currentValue < targetValue) {
      requestAnimationFrame(animateValue);
    } else {
      kwhElement.textContent = targetValue.toFixed(2);
    }
  };

  animateValue();
});

// Wert Animation
window.addEventListener('DOMContentLoaded', () => {
  const kwhElement = document.getElementById('kwh-year');
  const targetValue = parseInt(kwhElement.textContent); // Hole den Startwert

  let currentValue = 0; // Startwert für Animation
  const duration = 2000; // Dauer der Animation in Millisekunden
  const frameDuration = 1000 / 60; // Annahme von 60 FPS

  const totalFrames = Math.round(duration / frameDuration);
  const increment = targetValue / totalFrames;

  const animateValue = () => {
    currentValue += increment;
    kwhElement.textContent = currentValue.toFixed(2); // Auf zwei Dezimalstellen runden
    if (currentValue < targetValue) {
      requestAnimationFrame(animateValue);
    } else {
      kwhElement.textContent = targetValue.toFixed(2);
    }
  };

  animateValue();
});

// Wert Animation
window.addEventListener('DOMContentLoaded', () => {
  const kwhElement = document.getElementById('kwh-all');
  const targetValue = parseInt(kwhElement.textContent); // Hole den Startwert

  let currentValue = 0; // Startwert für Animation
  const duration = 2000; // Dauer der Animation in Millisekunden
  const frameDuration = 1000 / 60; // Annahme von 60 FPS

  const totalFrames = Math.round(duration / frameDuration);
  const increment = targetValue / totalFrames;

  const animateValue = () => {
    currentValue += increment;
    kwhElement.textContent = currentValue.toFixed(2); // Auf zwei Dezimalstellen runden
    if (currentValue < targetValue) {
      requestAnimationFrame(animateValue);
    } else {
      kwhElement.textContent = targetValue.toFixed(2);
    }
  };

  animateValue();
});