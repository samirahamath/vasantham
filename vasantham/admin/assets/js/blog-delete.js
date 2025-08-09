$(document).on('click', '.delete-blog-btn', function(){
    if(confirm("Are you sure you want to delete this blog?")) {
        window.location.href = "blog-delete.php?id=" + $(this).data("blog-id");
    }
});
