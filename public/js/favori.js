document.addEventListener('DOMContentLoaded', function() {
    const favoriLinks = document.querySelectorAll('a[href*="app_favori_"]');

    favoriLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            const icon = this.querySelector('i');

            fetch(url)
                .then(response => {
                    if (response.ok) {
                        if (url.includes('add')) {
                            this.href = url.replace('add', 'remove');
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                            this.classList.remove('btn-outline-danger');
                            this.classList.add('btn-danger');
                        } else {
                            this.href = url.replace('remove', 'add');
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                            this.classList.remove('btn-danger');
                            this.classList.add('btn-outline-danger');
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
