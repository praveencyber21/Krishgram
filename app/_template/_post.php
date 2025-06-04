<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .image-upload-card {
        position: relative;
        width: 300px;
        height: 300px;
        border: 2px dashed #ccc;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
        font-size: 48px;
        transition: border-color 0.3s, color 0.3s;
        margin-bottom: 1rem;
    }

    .image-upload-card:hover {
        border-color: #007bff;
        color: #007bff;
    }

    .image-upload-card input[type="file"] {
        display: none;
    }

    .image-upload-card img.preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>
<form action="post.php" method="post">
    <div class="d-flex flex-column align-items-center">
        <div class="image-upload-card" onclick="document.getElementById('fileInput').click();">
            <span id="plusIcon">+</span>
            <input type="file" id="fileInput" accept="image/*" name="fileInput" onchange="previewImage(event)" />
            <img id="preview" class="preview d-none" alt="Image preview" />
        </div>

        <textarea class="form-control w-100" style="max-width:300px;" rows="3" id="caption" name="caption" placeholder="Write a caption..."></textarea>

        <button class="btn btn-primary mt-3" style="width:300px;" type="submit">Post</button>
    </div>
</form>


<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const plusIcon = document.getElementById('plusIcon');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('d-none');
            plusIcon.style.display = 'none';
        } else {
            preview.classList.add('d-none');
            preview.src = '';
            plusIcon.style.display = 'inline';
        }
    }
</script>