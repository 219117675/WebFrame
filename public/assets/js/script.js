// script.js - Handles user login, registration, event CRUD, booking, and UI updates

document.addEventListener('DOMContentLoaded', () => {
  initializeApp();
});

function initializeApp() {
  updateNavLinks();
  setupSearchFilter();

  // Load events for public pages or admin dashboard
  if (document.getElementById('eventList')) {
    renderEvents();
  }
  if (document.getElementById('eventListAdmin')) {
    checkAdminAccess();
    setupAdminDashboard();
  }

  // Setup registration/login forms if on that page
  if (document.getElementById('registerForm')) {
    setupRegisterForm();
  }
  if (document.getElementById('loginForm')) {
    setupLoginForm();
  }

  // If on confirmation page, display booking info
  if (document.getElementById('confirmationDetails')) {
    displayConfirmation();
  }
}

// ------------------- User & Auth Management -------------------

function getUsers() {
  return JSON.parse(localStorage.getItem('users') || '[]');
}

function saveUsers(users) {
  localStorage.setItem('users', JSON.stringify(users));
}

function getCurrentUser() {
  return JSON.parse(localStorage.getItem('currentUser'));
}

function setCurrentUser(user) {
  localStorage.setItem('currentUser', JSON.stringify(user));
}

function logout() {
  localStorage.removeItem('currentUser');
  alert('Logged out successfully.');
  window.location.href = 'index.html';
}

function updateNavLinks() {
  const user = getCurrentUser();
  const authLink = document.getElementById('authLink');
  const dashboardLink = document.getElementById('dashboardLink');
  const logoutBtn = document.getElementById('logoutBtn');

  if (user) {
    if (authLink) authLink.style.display = 'none';
    if (logoutBtn) logoutBtn.style.display = 'inline-block';
    if (dashboardLink) {
      dashboardLink.style.display = user.role === 'Admin' ? 'inline-block' : 'none';
    }
  } else {
    if (authLink) authLink.style.display = 'inline-block';
    if (dashboardLink) dashboardLink.style.display = 'none';
    if (logoutBtn) logoutBtn.style.display = 'none';
  }
}

// ------------------- Registration & Login -------------------

function setupRegisterForm() {
  const form = document.getElementById('registerForm');
  form.addEventListener('submit', e => {
    e.preventDefault();
    const email = form.email.value.trim().toLowerCase();
    const password = form.password.value;
    const role = form.role.value;

    if (!email || !password || !role) {
      alert('Please fill in all fields.');
      return;
    }

    const users = getUsers();
    if (users.some(u => u.email === email)) {
      alert('User with this email already exists.');
      return;
    }

    users.push({ email, password, role });
    saveUsers(users);
    alert('Registration successful! You can now log in.');
    form.reset();
  });
}

function setupLoginForm() {
  const form = document.getElementById('loginForm');
  form.addEventListener('submit', e => {
    e.preventDefault();
    const email = form.loginEmail.value.trim().toLowerCase();
    const password = form.loginPassword.value;

    const users = getUsers();
    const user = users.find(u => u.email === email && u.password === password);

    if (!user) {
      alert('Invalid email or password.');
      return;
    }

    setCurrentUser(user);
    alert(`Welcome back, ${user.email}!`);

    if (user.role === 'Admin') {
      window.location.href = 'dashboard.html';
    } else {
      window.location.href = 'index.html';
    }
  });
}

// ------------------- Events Management -------------------

function getEvents() {
  return JSON.parse(localStorage.getItem('events') || '[]');
}

function saveEvents(events) {
  localStorage.setItem('events', JSON.stringify(events));
}

function renderEvents(filter = '') {
  const container = document.getElementById('eventList');
  if (!container) return;

  let events = getEvents();

  if (filter) {
    const f = filter.toLowerCase();
    events = events.filter(e => e.name.toLowerCase().includes(f) || e.location.toLowerCase().includes(f));
  }

  container.innerHTML = '';

  if (events.length === 0) {
    container.innerHTML = '<p>No events found.</p>';
    return;
  }

  events.forEach(event => {
    const card = document.createElement('div');
    card.className = 'event-card';
    card.innerHTML = `
      <h3>${event.name}</h3>
      <p><strong>Date:</strong> ${event.date}</p>
      <p><strong>Location:</strong> ${event.location}</p>
      <p>${event.description}</p>
      <button onclick="bookEvent('${event.id}')">Book Ticket</button>
    `;
    container.appendChild(card);
  });
}

// ------------------- Booking -------------------

function bookEvent(eventId) {
  const user = getCurrentUser();
  if (!user) {
    alert('You must be logged in to book an event.');
    window.location.href = 'register.html';
    return;
  }
  const events = getEvents();
  const event = events.find(e => e.id === eventId);
  if (!event) {
    alert('Event not found.');
    return;
  }

  // Save booking info in sessionStorage to show on confirmation page
  sessionStorage.setItem('booking', JSON.stringify({
    userEmail: user.email,
    eventName: event.name,
    eventDate: event.date,
    eventLocation: event.location
  }));

  window.location.href = 'confirmation.html';
}

// ------------------- Confirmation -------------------

function displayConfirmation() {
  const container = document.getElementById('confirmationDetails');
  const booking = JSON.parse(sessionStorage.getItem('booking'));
  if (!booking) {
    container.innerHTML = '<p>No booking details found.</p>';
    return;
  }

  container.innerHTML = `
    <p>Thank you, <strong>${booking.userEmail}</strong>, for booking a ticket!</p>
    <p><strong>Event:</strong> ${booking.eventName}</p>
    <p><strong>Date:</strong> ${booking.eventDate}</p>
    <p><strong>Location:</strong> ${booking.eventLocation}</p>
  `;
}

// ------------------- Admin Dashboard -------------------

function checkAdminAccess() {
  const user = getCurrentUser();
  if (!user || user.role !== 'Admin') {
    alert('Access denied. Admins only.');
    window.location.href = 'index.html';
  }
}

function setupAdminDashboard() {
  const createBtn = document.getElementById('createEventBtn');
  const modal = document.getElementById('eventModal');
  const closeModal = document.getElementById('closeModal');
  const form = document.getElementById('eventForm');
  const modalTitle = document.getElementById('modalTitle');
  const saveBtn = document.getElementById('saveEventBtn');

  let editMode = false;

  createBtn.addEventListener('click', () => {
    openModal();
  });

  closeModal.addEventListener('click', () => {
    closeModalFunc();
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) closeModalFunc();
  });

  form.addEventListener('submit', e => {
    e.preventDefault();
    const id = form.eventId.value;
    const name = form.eventName.value.trim();
    const date = form.eventDate.value;
    const location = form.eventLocation.value.trim();
    const description = form.eventDescription.value.trim();

    if (!name || !date || !location || !description) {
      alert('Please fill in all fields.');
      return;
    }

    let events = getEvents();

    if (editMode) {
      // Edit existing
      const idx = events.findIndex(ev => ev.id === id);
      if (idx !== -1) {
        events[idx] = { id, name, date, location, description };
      }
    } else {
      // Create new
      events.push({
        id: Date.now().toString(),
        name,
        date,
        location,
        description
      });
    }

    saveEvents(events);
    renderAdminEvents();
    closeModalFunc();
  });

  function openModal(edit = false, event = null) {
    editMode = edit;
    modal.style.display = 'block';
    if (edit && event) {
      modalTitle.textContent = 'Edit Event';
      form.eventId.value = event.id;
      form.eventName.value = event.name;
      form.eventDate.value = event.date;
      form.eventLocation.value = event.location;
      form.eventDescription.value = event.description;
    } else {
      modalTitle.textContent = 'Create Event';
      form.reset();
      form.eventId.value = '';
    }
  }

  function closeModalFunc() {
    modal.style.display = 'none';
  }

  window.openModal = openModal; // make accessible globally for edit buttons

  // Render admin event list with edit/delete buttons
  function renderAdminEvents() {
    const container = document.getElementById('eventListAdmin');
    container.innerHTML = '';

    let events = getEvents();
    if (events.length === 0) {
      container.innerHTML = '<p>No events found.</p>';
      return;
    }

    events.forEach(event => {
      const div = document.createElement('div');
      div.className = 'event-card';
      div.innerHTML = `
        <h3>${event.name}</h3>
        <p><strong>Date:</strong> ${event.date}</p>
        <p><strong>Location:</strong> ${event.location}</p>
        <p>${event.description}</p>
        <button class="admin-btn" onclick="openModal(true, ${JSON.stringify(event).replace(/\"/g, '&quot;')})">Edit</button>
        <button class="admin-btn delete" onclick="deleteEvent('${event.id}')">Delete</button>
      `;
      container.appendChild(div);
    });
  }

  renderAdminEvents();
}

function deleteEvent(id) {
  if (!confirm('Are you sure you want to delete this event?')) return;
  let events = getEvents();
  events = events.filter(e => e.id !== id);
  saveEvents(events);
  // Re-render admin list and public list if visible
  if (document.getElementById('eventListAdmin')) {
    document.getElementById('eventListAdmin').innerHTML = '';
    events.forEach(event => {
      // Re-render called inside setupAdminDashboard so best to just reload page:
    });
    window.location.reload();
  }
  if (document.getElementById('eventList')) {
    renderEvents();
  }
}

// ------------------- Search -------------------

function setupSearchFilter() {
  const searchInput = document.getElementById('search');
  if (!searchInput) return;

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim();
    if (document.getElementById('eventList')) {
      renderEvents(query);
    }
    if (document.getElementById('eventListAdmin')) {
      // For admin, just filter events by name/location on admin list as well:
      filterAdminEvents(query);
    }
  });
}

function filterAdminEvents(query) {
  const container = document.getElementById('eventListAdmin');
  if (!container) return;
  query = query.toLowerCase();

  let events = getEvents();
  if (query) {
    events = events.filter(e => e.name.toLowerCase().includes(query) || e.location.toLowerCase().includes(query));
  }

  container.innerHTML = '';

  if (events.length === 0) {
    container.innerHTML = '<p>No events found.</p>';
    return;
  }

  events.forEach(event => {
    const div = document.createElement('div');
    div.className = 'event-card';
    div.innerHTML = `
      <h3>${event.name}</h3>
      <p><strong>Date:</strong> ${event.date}</p>
      <p><strong>Location:</strong> ${event.location}</p>
      <p>${event.description}</p>
      <button class="admin-btn" onclick="openModal(true, ${JSON.stringify(event).replace(/\"/g, '&quot;')})">Edit</button>
      <button class="admin-btn delete" onclick="deleteEvent('${event.id}')">Delete</button>
    `;
    container.appendChild(div);
  });
}
