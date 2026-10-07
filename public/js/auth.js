/**
 * SiKlinik - Auth Portal Script
 */
document.addEventListener('DOMContentLoaded', () => {
    // Add dynamic input focus animation triggers
    const inputs = document.querySelectorAll('.flex.flex-col.gap-1.5 input');
    inputs.forEach((input) => {
        input.addEventListener('focus', () => {
            const container = input.closest('.flex-col');
            if (container) {
                container.classList.add('scale-[1.01]');
                container.style.transition = 'transform 0.2s ease-in-out';
            }
        });
        input.addEventListener('blur', () => {
            const container = input.closest('.flex-col');
            if (container) {
                container.classList.remove('scale-[1.01]');
            }
        });
    });
});
