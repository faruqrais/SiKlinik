/**
 * SiKlinik - Dashboard portal interactives
 */
document.addEventListener('DOMContentLoaded', () => {
    // Add micro hover glows for metric cards
    const statCards = document.querySelectorAll('.grid-cols-1 > div');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('border-blue-300', 'shadow-blue-50/50');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('border-blue-300', 'shadow-blue-50/50');
        });
    });
});
/**
 * Log events
 */
console.log('SiKlinik Dashboard loaded successfully.');
