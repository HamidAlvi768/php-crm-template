// Sidebar Toggle for Mobile
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.querySelector('.sidebar')?.classList.toggle('active');
});

// Sales Chart
const salesCtx = document.getElementById('salesChart')?.getContext('2d');
if (salesCtx && typeof Chart !== 'undefined') {
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sales',
                data: [30000, 35000, 32000, 42000, 45000, 48000, 52000, 58000, 61000, 55000, 59000, 65000],
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--color-primary'),
                backgroundColor: 'rgba(74, 144, 226, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: function(value) { return '$' + value.toLocaleString(); } }
                }
            }
        }
    });
}

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

// Misc behaviors
document.querySelectorAll('.icon-button').forEach(btn => {
    btn.addEventListener('click', function() {
        console.log('Notification clicked');
    });
});

document.querySelectorAll('.table-custom tbody tr').forEach(row => {
    row.addEventListener('click', function(e) {
        if (!e.target.closest('button')) {
            console.log('Row clicked');
        }
    });
});

// Customers page: open modal for add/edit
document.addEventListener('click', function(e) {
    const addBtn = e.target.closest('.btn-primary-custom');
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
        document.querySelectorAll('.table-custom tbody tr').forEach(tr => {
            const rowName = tr.children[0]?.innerText?.toLowerCase() || '';
            const rowEmail = tr.children[1]?.innerText?.toLowerCase() || '';
            const rowPhone = tr.children[2]?.innerText?.toLowerCase() || '';
            const rowStatus = tr.querySelector('.badge-custom')?.textContent || '';
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
        document.querySelectorAll('.table-custom tbody tr').forEach(tr => tr.style.display = '');
        updateCustomerClearVisibility();
    }
});

// Show/Hide Clear button depending on filters filled
function updateCustomerClearVisibility() {
    const clearBtn = document.getElementById('clearCustomerFilter');
    if (!clearBtn) return;
    const q = document.getElementById('filterQuery')?.value || '';
    const email = document.getElementById('filterEmail')?.value || '';
    const phone = document.getElementById('filterPhone')?.value || '';
    const status = document.getElementById('filterStatus')?.value || '';
    const hasAny = (q.trim() !== '' || email.trim() !== '' || phone.trim() !== '' || status.trim() !== '');
    clearBtn.style.display = hasAny ? '' : 'none';
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
            document.getElementById('customerPhone').value = editBtn.dataset.phone || '';
            document.getElementById('customerStatus').value = editBtn.dataset.status || 'Active';
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    }
});


