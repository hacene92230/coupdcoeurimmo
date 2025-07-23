document.addEventListener('DOMContentLoaded', function() {
    const favoriLinks = document.querySelectorAll('a[href*="app_favori_"]');

    favoriLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            const icon = this.querySelector('i');

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.isFavori) {
                    this.href = data.url;
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-danger');
                    this.setAttribute('aria-label', 'Retirer des favoris');
                } else {
                    this.href = data.url;
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-danger');
                    this.setAttribute('aria-label', 'Ajouter aux favoris');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
