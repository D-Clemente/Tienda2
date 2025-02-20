document.addEventListener('DOMContentLoaded', () => {
    // Lazy Load
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => {
        img.dataset.src = img.src;
        img.src = '';
        observer.observe(img);
    });

    // Carrito dinámico
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    
    document.querySelectorAll('.btn-carrito').forEach(btn => {
        btn.addEventListener('click', () => {
            const producto = {
                id: btn.dataset.id,
                nombre: btn.dataset.nombre,
                precio: btn.dataset.precio,
                imagen: btn.closest('.producto').querySelector('img').dataset.src
            };
            
            carrito.push(producto);
            actualizarCarrito();
        });
    });

    function actualizarCarrito() {
        localStorage.setItem('carrito', JSON.stringify(carrito));
        document.querySelector('.carrito-contador').textContent = carrito.length;
    }

    // Animaciones
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'scale(1.05)';
        });
        
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'scale(1)';
        });
    });
});