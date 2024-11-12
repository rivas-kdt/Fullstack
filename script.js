document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById("myModal");
    const span = document.getElementsByClassName("close")[0];
    const modalId = document.getElementById("modalId");
    const modalName = document.getElementById("modalName");
    const modalCat = document.getElementById("modalCat");
    const modalDesc = document.getElementById("modalDesc");
    const modalPrc = document.getElementById("modalPrc");

    document.querySelectorAll('.openModalBtn').forEach(button => {
        button.onclick = function () {
            id = this.getAttribute('data-id');
            fetch(`http://localhost/try/api/product.php?ID=${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    modalId.textContent = data.prod_id;
                    modalName.textContent = data.prod_name;
                    modalCat.textContent = data.cat_name;
                    modalDesc.textContent = data.prod_desc;
                    modalPrc.textContent = data.prod_price;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            modal.style.display = "block";
        }
    });
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
