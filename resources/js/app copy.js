import './bootstrap';

 // Difference in milliseconds

if (role == "user") {
    window.Echo.private("users." + id)
        .notification((event) => {
            
            $('#push-notifications').prepend(`
            <div class="dropdown-item d-flex justify-content-between align-items-center">
                <span>Post comment: ${event.post_title.substring(0, 5)}...</span>
                <a href="${event.link}?notify=${event.id}" class="btn btn-sm btn-danger"><i class="fas fa-eye"></i></a>
            </div>
            
            `);

            count = Number($('#count-notifications').text());
            count++;
            $('#count-notifications').text(count);
        })
} 

if(role == "admin") {
    window.Echo.private('admins.' + admin_id)
    
        .notification((event) => {
            $('#no-notifications').remove();
            $('#push-notifications-admin').prepend(`
            <a class="dropdown-item d-flex align-items-center" href="${event.link}?notify=${event.id}">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <span class="font-weight-bold">${event.contact_title}</span>
                    </div>
                </a>
            
            `);

            count = Number($('#count-notifications-admin').text());
            count++;
            $('#count-notifications-admin').text(count);
        })
}


