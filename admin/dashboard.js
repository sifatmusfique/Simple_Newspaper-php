document.addEventListener("DOMContentLoaded", () => {
  const articleModal = document.getElementById("article-modal");
  const addArticleBtn = document.getElementById("add-article-btn");
  const cancelBtn = document.getElementById("cancel-btn");
  const modalTitle = document.getElementById("modal-title");
  const articleForm = document.getElementById("article-form");
  const articleIdInput = document.getElementById("article-id");
  const imageFileInput = document.getElementById("image_file");
  const existingImagePathInput = document.getElementById("existing_image_path");

  const openModal = () =>
    articleModal && articleModal.classList.remove("hidden");

  const closeModal = () => {
    if (articleModal) {
      articleModal.classList.add("hidden");
      articleForm.reset();
      articleIdInput.value = "";
      existingImagePathInput.value = "";
      if (imageFileInput) imageFileInput.required = true;
    }
  };

  if (addArticleBtn) {
    addArticleBtn.addEventListener("click", () => {
      modalTitle.textContent = "Add New Article";
      if (imageFileInput) imageFileInput.required = true;
      existingImagePathInput.value = "";
      openModal();
    });
  }

  if (cancelBtn) {
    cancelBtn.addEventListener("click", closeModal);
  }

  document.querySelectorAll(".edit-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
      const id = e.target.dataset.id;
      try {
        const response = await fetch(`api.php?action=get_article&id=${id}`);
        const result = await response.json();

        if (result.success) {
          const article = result.data;
          modalTitle.textContent = "Edit Article";
          articleIdInput.value = article.id;
          document.getElementById("title").value = article.title;
          document.getElementById("category").value = article.category;
          existingImagePathInput.value = article.image_url;
          document.getElementById("content").value = article.content;

          if (imageFileInput) imageFileInput.required = false;
          openModal();
        } else {
          alert("Error fetching article: " + result.message);
        }
      } catch (error) {
        console.error("Fetch error:", error);
        alert(
          "An error occurred while fetching article data. Check console for details."
        );
      }
    });
  });

  if (articleForm) {
    articleForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(articleForm);
      formData.append("action", "save_article");

      const isEditing = formData.get("id") && formData.get("id").length > 0;
      if (isEditing && imageFileInput && imageFileInput.files.length === 0) {
        formData.delete("image_file");
      } else if (
        !isEditing &&
        imageFileInput &&
        imageFileInput.files.length === 0
      ) {
        alert("Please select an image file.");
        return;
      }

      try {
        const response = await fetch("api.php", {
          method: "POST",
          body: formData,
        });
        const result = await response.json();

        if (result.success) {
          alert(result.message);
          window.location.reload();
        } else {
          alert("Error saving article: " + result.message);
        }
      } catch (error) {
        console.error("Submit error:", error);
        alert(
          "An error occurred while saving the article. Check console for details."
        );
      }
    });
  }

  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", async (e) => {
      const id = e.target.dataset.id;
      if (confirm("Are you sure you want to delete this article?")) {
        try {
          const formData = new FormData();
          formData.append("action", "delete_article");
          formData.append("id", id);

          const response = await fetch("api.php", {
            method: "POST",
            body: formData,
          });
          const result = await response.json();

          if (result.success) {
            alert(result.message);
            window.location.reload();
          } else {
            alert("Error deleting article: " + result.message);
          }
        } catch (error) {
          console.error("Delete error:", error);
          alert(
            "An error occurred while deleting the article. Check console for details."
          );
        }
      }
    });
  });
});
