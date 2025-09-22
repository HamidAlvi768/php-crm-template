// Sidebar Toggle for Mobile
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.querySelector('.sidebar')?.classList.toggle('active');
});

// Sales Chart with Dynamic Data
let salesChart = null;
const salesCtx = document.getElementById('salesChart')?.getContext('2d');

// Sales data for different time periods
const salesData = {
    day: {
        labels: ['12 AM', '3 AM', '6 AM', '9 AM', '12 PM', '3 PM', '6 PM', '9 PM'],
        data: [1200, 800, 1500, 3200, 4800, 5200, 3800, 2100]
    },
    month: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        data: [30000, 35000, 32000, 42000, 45000, 48000, 52000, 58000, 61000, 55000, 59000, 65000]
    },
    year: {
        labels: ['2020', '2021', '2022', '2023', '2024'],
        data: [450000, 520000, 480000, 680000, 750000]
    }
};

// Function to create/update the sales chart
function createSalesChart(period = 'month') {
    if (!salesCtx || typeof Chart === 'undefined') return;
    
    const chartData = salesData[period];
    
    if (salesChart) {
        salesChart.destroy();
    }
    
    salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Sales',
                data: chartData.data,
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--color-primary'),
                backgroundColor: 'rgba(74, 144, 226, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Sales: $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        callback: function(value) { 
                            return '$' + value.toLocaleString(); 
                        } 
                    }
                }
            }
        }
    });
}

// Initialize the chart with month data
if (salesCtx) {
    createSalesChart('month');
}

// Sales Overview Button Functionality
document.addEventListener('DOMContentLoaded', function() {
    const dayBtn = document.getElementById('salesDayBtn');
    const monthBtn = document.getElementById('salesMonthBtn');
    const yearBtn = document.getElementById('salesYearBtn');
    
    // Function to update button states
    function updateButtonStates(activePeriod) {
        // Reset all buttons
        [dayBtn, monthBtn, yearBtn].forEach(btn => {
            if (btn) {
                btn.classList.remove('btn--primary');
                btn.classList.add('btn--secondary');
            }
        });
        
        // Set active button
        const activeBtn = document.getElementById(`sales${activePeriod.charAt(0).toUpperCase() + activePeriod.slice(1)}Btn`);
        if (activeBtn) {
            activeBtn.classList.remove('btn--secondary');
            activeBtn.classList.add('btn--primary');
        }
    }
    
    // Day button click
    if (dayBtn) {
        dayBtn.addEventListener('click', function() {
            createSalesChart('day');
            updateButtonStates('day');
        });
    }
    
    // Month button click
    if (monthBtn) {
        monthBtn.addEventListener('click', function() {
            createSalesChart('month');
            updateButtonStates('month');
        });
    }
    
    // Year button click
    if (yearBtn) {
        yearBtn.addEventListener('click', function() {
            createSalesChart('year');
            updateButtonStates('year');
        });
    }
});

// Lead Source Chart
const leadCtx = document.getElementById('leadSourceChart')?.getContext('2d');
if (leadCtx && typeof Chart !== 'undefined') {
    new Chart(leadCtx, {
        type: 'doughnut',
        data: {
            labels: ['Website', 'Social Media', 'Email', 'Referral', 'Direct'],
            datasets: [{
                data: [35, 25, 20, 15, 5],
                backgroundColor: [
                    getComputedStyle(document.documentElement).getPropertyValue('--color-primary'),
                    getComputedStyle(document.documentElement).getPropertyValue('--color-success'),
                    getComputedStyle(document.documentElement).getPropertyValue('--color-warning'),
                    getComputedStyle(document.documentElement).getPropertyValue('--color-info'),
                    getComputedStyle(document.documentElement).getPropertyValue('--color-danger')
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}

// Patient Distribution by Area Chart
const patientAreaCtx = document.getElementById('patientAreaChart')?.getContext('2d');
if (patientAreaCtx && typeof Chart !== 'undefined') {
    new Chart(patientAreaCtx, {
        type: 'bar',
        data: {
            labels: ['Downtown', 'North Side', 'East District', 'West End', 'South Zone', 'Central'],
            datasets: [{
                label: 'Number of Patients',
                data: [245, 189, 156, 134, 98, 87],
                backgroundColor: [
                    'rgba(74, 144, 226, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(6, 182, 212, 0.8)'
                ],
                borderColor: [
                    'rgba(74, 144, 226, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(251, 191, 36, 1)',
                    'rgba(168, 85, 247, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(6, 182, 212, 1)'
                ],
                borderWidth: 2,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Patients: ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}


// Notification Dropdown Functionality
document.addEventListener('DOMContentLoaded', function() {
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationMenu = document.getElementById('notificationMenu');
    const notificationItems = document.querySelectorAll('.notification-item');
    const notificationBadge = document.querySelector('.notification-badge');

    // Toggle notification dropdown
    if (notificationToggle && notificationMenu) {
        notificationToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpening = !notificationMenu.classList.contains('show');
            notificationMenu.classList.toggle('show');
            
            // Mark all notifications as read when opening the dropdown
            if (isOpening) {
                notificationItems.forEach(item => {
                    item.classList.remove('unread');
                });
                updateNotificationBadge();
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.notification-dropdown')) {
            notificationMenu?.classList.remove('show');
        }
    });


    // Mark individual notification as read when clicked
    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            this.classList.remove('unread');
            updateNotificationBadge();
        });
    });

    // Function to update notification badge count
    function updateNotificationBadge() {
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        if (notificationBadge) {
            notificationBadge.textContent = unreadCount;
            notificationBadge.style.display = unreadCount > 0 ? 'flex' : 'none';
        }
    }

    // Initialize badge count
    updateNotificationBadge();
});

// User Profile Dropdown Functionality
document.addEventListener('DOMContentLoaded', function() {
    const userProfileToggle = document.getElementById('userProfileToggle');
    const userProfileMenu = document.getElementById('userProfileMenu');

    // Toggle profile dropdown
    if (userProfileToggle && userProfileMenu) {
        userProfileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userProfileMenu.classList.toggle('show');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-profile-dropdown')) {
            userProfileMenu?.classList.remove('show');
        }
    });
});

document.querySelectorAll('.table tbody tr').forEach(row => {
    row.addEventListener('click', function(e) {
        if (!e.target.closest('button')) {
            console.log('Row clicked');
        }
    });
});

// Customers page: open modal for add/edit
document.addEventListener('click', function(e) {
    const addBtn = e.target.closest('.btn--primary');
    if (addBtn && addBtn.textContent.trim().includes('Add Customer')) {
        const modalEl = document.getElementById('customerModal');
        if (modalEl) {
            const titleEl = document.getElementById('customerModalTitle');
            const form = document.getElementById('customerForm');
            titleEl.textContent = 'Add Customer';
            form.reset();
            document.getElementById('customerIndex').value = '';
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
});

// Customers page: filter interactions
document.addEventListener('click', function(e) {
    if (e.target.id === 'applyCustomerFilter') {
        const q = document.getElementById('filterQuery')?.value.toLowerCase() || '';
        const email = document.getElementById('filterEmail')?.value.toLowerCase() || '';
        const phone = document.getElementById('filterPhone')?.value.toLowerCase() || '';
        const status = document.getElementById('filterStatus')?.value || '';
        document.querySelectorAll('.table tbody tr').forEach(tr => {
            const rowName = tr.children[0]?.innerText?.toLowerCase() || '';
            const rowEmail = tr.children[1]?.innerText?.toLowerCase() || '';
            const rowPhone = tr.children[2]?.innerText?.toLowerCase() || '';
            const rowStatus = tr.querySelector('.badge')?.textContent || '';
            const matchesName = q === '' || rowName.includes(q);
            const matchesEmail = email === '' || rowEmail.includes(email);
            const matchesPhone = phone === '' || rowPhone.includes(phone);
            const matchesStatus = status === '' || rowStatus === status;
            tr.style.display = (matchesName && matchesEmail && matchesPhone && matchesStatus) ? '' : 'none';
        });
        // update clear button visibility after applying
        updateCustomerClearVisibility();
    }
    if (e.target.id === 'clearCustomerFilter') {
        const qInput = document.getElementById('filterQuery');
        const eInput = document.getElementById('filterEmail');
        const pInput = document.getElementById('filterPhone');
        const sSelect = document.getElementById('filterStatus');
        if (qInput) qInput.value = '';
        if (eInput) eInput.value = '';
        if (pInput) pInput.value = '';
        if (sSelect) sSelect.value = '';
        document.querySelectorAll('.table tbody tr').forEach(tr => tr.style.display = '');
        updateCustomerClearVisibility();
    }
});

// Enable/Disable Clear button depending on filters filled
function updateCustomerClearVisibility() {
    const clearBtn = document.getElementById('clearCustomerFilter');
    if (!clearBtn) return;
    const q = document.getElementById('filterQuery')?.value || '';
    const email = document.getElementById('filterEmail')?.value || '';
    const phone = document.getElementById('filterPhone')?.value || '';
    const status = document.getElementById('filterStatus')?.value || '';
    const hasAny = (q.trim() !== '' || email.trim() !== '' || phone.trim() !== '' || status.trim() !== '');
    clearBtn.disabled = !hasAny;
}

['filterQuery','filterEmail','filterPhone'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', updateCustomerClearVisibility);
});
const statusEl = document.getElementById('filterStatus');
if (statusEl) statusEl.addEventListener('change', updateCustomerClearVisibility);

// Initialize on load
document.addEventListener('DOMContentLoaded', updateCustomerClearVisibility);

document.addEventListener('click', function(e) {
    const editBtn = e.target.closest('.edit-customer-btn');
    if (editBtn) {
        const modalEl = document.getElementById('customerModal');
        if (modalEl) {
            const titleEl = document.getElementById('customerModalTitle');
            const form = document.getElementById('customerForm');
            titleEl.textContent = 'Edit Customer';
            document.getElementById('customerIndex').value = editBtn.dataset.index || '';
            document.getElementById('customerName').value = editBtn.dataset.name || '';
            document.getElementById('customerEmail').value = editBtn.dataset.email || '';
            document.getElementById('customerAge').value = editBtn.dataset.age || '';
            document.getElementById('customerBirthDate').value = editBtn.dataset.birthDate || '';
            document.getElementById('customerNotes').value = editBtn.dataset.notes || '';
            document.getElementById('customerStatus').value = editBtn.dataset.status || '';
            // Note: File input cannot be pre-filled for security reasons
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
});

// Customer View Modal Functionality
document.addEventListener('click', function(e) {
    const viewBtn = e.target.closest('.btn');
    if (viewBtn && viewBtn.querySelector('.fa-eye')) {
        // Get customer data from the row
        const row = viewBtn.closest('tr');
        if (row) {
            const cells = row.querySelectorAll('td');
            const customerData = {
                name: cells[0]?.textContent?.trim() || 'Unknown',
                email: cells[1]?.textContent?.trim() || '',
                phone: cells[2]?.textContent?.trim() || '',
                status: cells[3]?.querySelector('.badge')?.textContent?.trim() || 'Unknown',
                revenue: cells[4]?.textContent?.trim() || 'PKR 0'
            };
            
            // Populate view modal with customer data
            populateCustomerViewModal(customerData);
            
            // Show the modal
            const modalEl = document.getElementById('customerViewModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }
    }
});

// Function to populate customer view modal
function populateCustomerViewModal(customerData) {
    // Update modal title with customer name
    document.getElementById('customerViewModalTitle').textContent = customerData.name;
    
    // Generate avatar initials
    const initials = customerData.name.split(' ').map(n => n[0]).join('').toUpperCase();
    
    // Update modal header avatar
    document.getElementById('customerViewModalAvatar').textContent = initials;
    
    // Update personal information section
    document.getElementById('customerViewEmail').textContent = customerData.email;
    document.getElementById('customerViewPhone').textContent = customerData.phone;
    
    // Update business information
    document.getElementById('customerViewStatusDetail').textContent = customerData.status;
    document.getElementById('customerViewRevenue').textContent = customerData.revenue;
    
    // Update status badge styling in business section
    const statusDetailBadge = document.getElementById('customerViewStatusDetail');
    statusDetailBadge.className = 'badge';
    if (customerData.status === 'Active') {
        statusDetailBadge.classList.add('badge--success');
    } else if (customerData.status === 'Pending') {
        statusDetailBadge.classList.add('badge--warning');
    } else if (customerData.status === 'Inactive') {
        statusDetailBadge.classList.add('badge--danger');
    }
    
    // Generate realistic dummy data based on customer name
    const dummyData = generateDummyCustomerData(customerData.name);
    
    // Set realistic values for missing data
    document.getElementById('customerViewAge').textContent = dummyData.age;
    document.getElementById('customerViewBirthDate').textContent = dummyData.birthDate;
    
    // Handle notes with realistic content
    const notesElement = document.getElementById('customerViewNotes');
    notesElement.innerHTML = `<p>${dummyData.notes}</p>`;
    notesElement.className = 'notes-content';
    
}

// Function to generate realistic dummy data based on customer name
function generateDummyCustomerData(customerName) {
    const dummyDataSets = [
        {
            age: '28',
            birthDate: '1995-03-15',
            notes: 'Preferred contact method is email. Customer has been with us for 2 years and shows high engagement with our services. Recently upgraded to premium package.'
        },
        {
            age: '34',
            birthDate: '1989-07-22',
            notes: 'Very responsive customer who prefers phone calls for urgent matters. Has referred 3 new customers to our business. Interested in additional services.'
        },
        {
            age: '42',
            birthDate: '1981-11-08',
            notes: 'Long-term customer with excellent payment history. Prefers detailed reports and regular updates. Very satisfied with current service level.'
        },
        {
            age: '26',
            birthDate: '1997-05-30',
            notes: 'New customer who joined through referral program. Very tech-savvy and prefers digital communication. Shows great potential for growth.'
        },
        {
            age: '38',
            birthDate: '1985-12-14',
            notes: 'Business customer with multiple accounts. Requires priority support and custom solutions. High-value client with expansion plans.'
        },
        {
            age: '31',
            birthDate: '1992-09-03',
            notes: 'Regular customer who appreciates personalized service. Often provides feedback and suggestions for improvement. Very loyal to our brand.'
        }
    ];
    
    // Use customer name to determine which dummy data to use (consistent for same name)
    const nameHash = customerName.split('').reduce((a, b) => {
        a = ((a << 5) - a) + b.charCodeAt(0);
        return a & a;
    }, 0);
    
    const dataIndex = Math.abs(nameHash) % dummyDataSets.length;
    return dummyDataSets[dataIndex];
}

// Edit Customer from View Modal
document.addEventListener('click', function(e) {
    if (e.target.id === 'editCustomerFromView') {
        // Close view modal
        const viewModalEl = document.getElementById('customerViewModal');
        if (viewModalEl) {
            const viewModal = bootstrap.Modal.getInstance(viewModalEl);
            viewModal.hide();
        }
        
        // Open edit modal with current customer data
        const editModalEl = document.getElementById('customerModal');
        if (editModalEl) {
            const titleEl = document.getElementById('customerModalTitle');
            titleEl.textContent = 'Edit Customer';
            
            // Get data from view modal
            const customerName = document.getElementById('customerViewName').textContent;
            const customerEmail = document.getElementById('customerViewEmail').textContent;
            const customerPhone = document.getElementById('customerViewPhone').textContent;
            const customerStatus = document.getElementById('customerViewStatus').textContent;
            
            // Populate edit form
            document.getElementById('customerIndex').value = '';
            document.getElementById('customerName').value = customerName;
            document.getElementById('customerEmail').value = customerEmail;
            document.getElementById('customerAge').value = '';
            document.getElementById('customerBirthDate').value = '';
            document.getElementById('customerNotes').value = '';
            document.getElementById('customerStatus').value = customerStatus;
            
            // Show edit modal
            const editModal = new bootstrap.Modal(editModalEl);
            editModal.show();
        }
    }
});


