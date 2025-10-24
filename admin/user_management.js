document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".role-select").forEach((select) => {
    select.addEventListener("change", async function () {
      const userId = this.dataset.userid;
      const newRole = this.value;

      if (
        confirm(
          `Are you sure you want to change this user's role to '${newRole}'?`
        )
      ) {
        const formData = new FormData();
        formData.append("action", "change_role");
        formData.append("user_id", userId);
        formData.append("new_role", newRole);

        try {
          const response = await fetch("user_api.php", {
            method: "POST",
            body: formData,
          });
          const result = await response.json();
          alert(result.message);
          if (!result.success) {
            window.location.reload();
          }
        } catch (error) {
          console.error("Error:", error);
          alert("An error occurred while changing the user role.");
          window.location.reload();
        }
      } else {
        this.blur();
        window.location.reload();
      }
    });
  });

  document.querySelectorAll(".delete-user-btn").forEach((button) => {
    button.addEventListener("click", async function () {
      const userId = this.dataset.userid;

      if (
        confirm(
          "Are you sure you want to permanently delete this user? This action cannot be undone."
        )
      ) {
        const formData = new FormData();
        formData.append("action", "delete_user");
        formData.append("user_id", userId);

        try {
          const response = await fetch("user_api.php", {
            method: "POST",
            body: formData,
          });
          const result = await response.json();
          alert(result.message);
          if (result.success) {
            window.location.reload();
          }
        } catch (error) {
          console.error("Error:", error);
          alert("An error occurred while deleting the user.");
        }
      }
    });
  });
});
