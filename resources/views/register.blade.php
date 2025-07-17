<x-layout>
    
<section class="fade-in">
  <div class="card">
    <h2>Register</h2>
    <form id="registerForm">
      <label for="email">Email:</label>
      <input type="email" id="email" required />

      <label for="password">Password:</label>
      <input type="password" id="password" required />

      <label for="role">Select Role:</label>
      <select id="role" required>
        <option value="">--Select Role--</option>
        <option value="User">User</option>
        <option value="Admin">Admin</option>
      </select>

      <button type="submit">Register</button>
    </form>

    <hr />

    <h2>Login</h2>
    <form id="loginForm">
      <label for="loginEmail">Email:</label>
      <input type="email" id="loginEmail" required />

      <label for="loginPassword">Password:</label>
      <input type="password" id="loginPassword" required />

      <button type="submit">Login</button>
    </form>
  </div>
</section>




</x-layout>
