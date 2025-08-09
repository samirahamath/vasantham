$(document).on('click', '.toggle-blog-status-btn', function(){
    var id = $(this).data("blog-id");
    var action = $(this).data("action");
    window.location.href = "manage-blogs.php?action=" + action + "&id=" + id;
});
