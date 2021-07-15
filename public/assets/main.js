$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function required_fild(object) {
    for (const property in object) {
        if (`${object[property]}` == "" || `${object[property]}` == 'null' || `${object[property]}` == 'undefined') {
            console.log(`${object[property]}`);
            Swal.fire({
                icon: "error",
                text: "Mohon lengkapi file yang bertanda..!!",
            });
            return false;
        }
    }
}

function status_delete(result) {
    if (result == true) {
        return Swal.fire("Deleted!", "Your file has been deleted.", "success");
    } else {
        return Swal.fire("Deleted!", "Failed to delete.", "error");
    }
}

function call_toast(result) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    if (result) {
        return Toast.fire({
            icon: "success",
            title: "successfully",
        });
    } else {
        return Toast.fire({
            icon: "error",
            title: "successfully",
        });
    }
}
