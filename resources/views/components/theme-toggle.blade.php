<div id="theme-toggle" class="mr-3">
  <input type="checkbox" class="checkbox" id="checkbox"
         x-bind:checked="darkMode === 'dark'"
         x-on:change="darkMode = (darkMode === 'dark') ? 'light' : 'dark'"
  >
  <label for="checkbox" class="checkbox-label">
    <i class="fas fa-moon"></i>
    <i class="fas fa-sun"></i>
    <span class="ball"></span>
  </label>
</div>
