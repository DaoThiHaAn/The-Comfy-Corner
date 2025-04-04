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
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                // Font family dropdown
                [{ 'font': [] }],
                // Font size dropdown
                [{ 'size': ['small', false, 'large', 'huge'] }],
                // Header levels dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                // Basic styles: Bold, Italic, Underline, Strike
                ['bold', 'italic', 'underline', 'strike'],
                // Color and background picker
                [{ 'color': [] }, { 'background': [] }],
                // Subscript/Superscript
                [{ 'script': 'sub' }, { 'script': 'super' }],
                // List: Ordered, Bullet
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                // Indentation
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                // Text direction (RTL)
                [{ 'direction': 'rtl' }],
                // Alignment options
                [{ 'align': [] }],
                // Link, Image, Video
                ['link', 'image', 'video'],
                // Clean formatting button
                ['clean']
            ]
        }
    });
  
    // Handle form submission: save the HTML output into the hidden input
    const form = document.querySelector('.add-form');
    form.addEventListener('submit', function() {
        document.getElementById('description').value = quill.root.innerHTML;
    });
});

var product_image = document.getElementById("product_image");
if (product_image) {
    product_image.addEventListener("change", function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById("preview");
                previewImg.src = e.target.result;
                previewImg.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
    
}


