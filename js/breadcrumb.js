document.addEventListener("DOMContentLoaded", function () {
    const breadcrumbTree = document.querySelector(".breadcrumb-tree");

    // URL hiện tại
    const urlParams = new URLSearchParams(window.location.search);
    const managementParam = urlParams.get("management"); // Lấy giá trị của query "management"
    const idParam = urlParams.get("id"); // Lấy giá trị của query "id" (dành cho product hoặc product_catelog)

    // Tạo breadcrumb với liên kết đầu tiên là "Trang chủ"
    const breadcrumbHtml = [`<li><a href="/web1/index.php">Trang chủ</a></li>`];

    // Kiểm tra nếu có tham số "management" trong URL
    if (managementParam) {
        // Định nghĩa các trang có thể có
        const breadcrumbMap = {
            news: "Tin tức",
            contact: "Liên hệ",
            go_store: "Cửa hàng",
            view_order: "Xem đơn hàng",
            order_history: "Lịch sử đơn hàng",
            change_password: "Đổi mật khẩu",
            thanks: "Cảm ơn",
            search: "Tìm kiếm",
            pay: "Thanh toán",
            order_placed: "Đặt hàng",
            payment_information: "Thông tin thanh toán",
            transport: "Vận chuyển",
            login: "Đăng nhập",
            register: "Đăng ký",
            product: "Sản phẩm",
            comment: "Bình luận",
            article: "Bài viết",
            manage_article_categories: "Quản lý danh mục bài viết",
            shopping_cart: "Giỏ hàng",
            product_catelog: "Danh mục sản phẩm"
        };

        // Lấy tên trang tương ứng từ query string
        const pageName = breadcrumbMap[managementParam] || "Không xác định";
        breadcrumbHtml.push(`<li class="active">${pageName}</li>`);

        // Nếu là trang danh mục sản phẩm, lấy tên danh mục từ cơ sở dữ liệu
        if (managementParam === "product_catelog" && idParam) {
            fetch(`/web1/processing/get_category_name.php?id=${idParam}`)
                .then(response => {
                    // Kiểm tra xem phản hồi có phải là JSON không
                    return response.text().then(text => {
                        try {
                            // Kiểm tra nếu phản hồi là JSON hợp lệ
                            const data = JSON.parse(text);
                            return data;
                        } catch (e) {
                            console.error("Không phải JSON hợp lệ:", text);
                            throw new Error("Dữ liệu trả về không phải là JSON hợp lệ.");
                        }
                    });
                })
                .then(data => {
                    const categoryName = data.ten || 'Danh mục không xác định';
                    breadcrumbHtml.push(`<li class="active">${categoryName}</li>`);
                    breadcrumbTree.innerHTML = breadcrumbHtml.join("");
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                    breadcrumbHtml.push(`<li class="active">Không thể tải danh mục</li>`);
                    breadcrumbTree.innerHTML = breadcrumbHtml.join("");
                });
        } 
        // Nếu là trang chi tiết sản phẩm
        else if (managementParam === "product" && idParam) {
            fetch(`/web1/processing/get_product_name.php?id=${idParam}`)
                .then(response => {
                    // Kiểm tra xem phản hồi có phải là JSON không
                    return response.text().then(text => {
                        try {
                            // Kiểm tra nếu phản hồi là JSON hợp lệ
                            const data = JSON.parse(text);
                            return data;
                        } catch (e) {
                            console.error("Không phải JSON hợp lệ:", text);
                            throw new Error("Dữ liệu trả về không phải là JSON hợp lệ.");
                        }
                    });
                })
                .then(data => {
                    const productName = data.tensanpham || 'Sản phẩm không xác định';
                    breadcrumbHtml.push(`<li class="active">${productName}</li>`);
                    breadcrumbTree.innerHTML = breadcrumbHtml.join("");
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                    breadcrumbHtml.push(`<li class="active">Không thể tải sản phẩm</li>`);
                    breadcrumbTree.innerHTML = breadcrumbHtml.join("");
                });
        }
        // Trường hợp không phải trang sản phẩm hoặc danh mục sản phẩm
        else {
            breadcrumbTree.innerHTML = breadcrumbHtml.join("");
        }
    } else {
        // Nếu không có query string "management", chỉ hiển thị breadcrumb cho trang chủ
        breadcrumbTree.innerHTML = breadcrumbHtml.join("");
    }
});
