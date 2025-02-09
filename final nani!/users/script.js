let users = [
    { id: 1, name: 'John Doe', email: 'john@example.com' },
    { id: 2, name: 'Jane Doe', email: 'jane@example.com' },
];

// Display users
function displayUsers() {
    const userTableBody = document.getElementById('user-table-body');
    userTableBody.innerHTML = '';
    users.forEach((user) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${(link unavailable)}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>
                <button class="edit-btn" data-id="${(link unavailable)}">Edit</button>
                <button class="delete-btn" data-id="${(link unavailable)}">Delete</button>
            </td>
        `;
        userTable