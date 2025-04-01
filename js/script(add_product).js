document.addEventListener('DOMContentLoaded', function() {
    var radios = document.getElementsByName('product_type');
    var newCategoryInput = document.getElementById('new_category_input');

    for (var i = 0; i < radios.length; i++) {
        radios[i].addEventListener('change', function() {
            if (document.getElementById('new_category_radio').checked) {
                newCategoryInput.style.display = 'block';
            } else {
                newCategoryInput.style.display = 'none';
            }
        });
    }

    // Initialize Quill editor if the editor exists
  
  
    function logHtmlContent() {
        console.log(quill.root.innerHTML);
    }
});


