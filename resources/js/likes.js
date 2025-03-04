document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            const url = form.getAttribute('action');
            const postId = this.getAttribute('data-post-id');
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _token: document.querySelector('input[name="_token"]').value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeIcon = button.querySelector('svg');
                    const likeCount = button.querySelector('.like-count');
                    
                    if (data.isLiked) {
                        button.classList.add('text-blue-600');
                        button.classList.remove('text-gray-500');
                        likeIcon.setAttribute('fill', 'currentColor');
                    } else {
                        button.classList.remove('text-blue-600');
                        button.classList.add('text-gray-500');
                        likeIcon.setAttribute('fill', 'none');
                    }
                    
                    likeCount.textContent = data.likesCount;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
});