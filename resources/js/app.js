import './bootstrap';
function formatTimeDifference() {
    const targetTime = new Date(); // Replace with your target time
    const currentTime = new Date();
    const timeDifference = currentTime - targetTime;
    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);

    if (years > 0) {
        return `${years} year${years > 1 ? 's' : ''} ago`;
    } else if (months > 0) {
        return `${months} month${months > 1 ? 's' : ''} ago`;
    } else if (days > 0) {
        return `${days} day${days > 1 ? 's' : ''} ago`;
    } else if (hours > 0) {
        return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    } else if (minutes > 0) {
        return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    } else if(seconds > 0) {
        return `${seconds} second${seconds > 1 ? 's' : ''} ago`;
    } else {
        return 'Just now';
    }
}
if (role == "user") {
    window.Echo.private("users." + id)
        .notification((event) => {
            let link = showPostRoute.replace(':slug', event.post_slug)+'?notify='+event.id;
            $('#push-notifications').prepend(`
            <div class="dropdown-item d-flex justify-content-between align-items-center">
                
            <span>Post comment: ${event.post_title.substring(0, 5)}...</span>
                <a href="${link}" class="btn btn-sm btn-danger"><i class="fas fa-eye"></i></a>
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
                    <div class="small text-gray-500">${formatTimeDifference()}</div>
                        <span class="font-weight-bold">${event.contact_title}</span>
                    </div>
                </a>
            
            `);

            count = Number($('#count-notifications-admin').text());
            count++;
            $('#count-notifications-admin').text(count);
        })
}


