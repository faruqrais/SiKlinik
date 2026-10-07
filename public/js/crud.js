/**
 * SiKlinik - CRUD Resource Deletion Script
 * Handles showing/hiding delete modals dynamically.
 */

document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    const deleteTargetName = document.getElementById('delete-target-name');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');

    if (deleteButtons.length > 0 && deleteModal && deleteForm && deleteTargetName) {
        
        // Loop through all delete triggers and add listeners
        deleteButtons.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                
                const url = btn.getAttribute('data-url');
                const name = btn.getAttribute('data-name');
                
                // Bind data values to delete form and modal content
                deleteForm.setAttribute('action', url);
                deleteTargetName.textContent = name;
                
                // Show modal overlay
                deleteModal.classList.remove('hidden');
                deleteModal.style.opacity = '1';
            });
        });

        // Hide modal on Cancel button press
        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.add('hidden');
            });
        }

        // Close modal if user clicks outside of modal card
        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
    }
});
