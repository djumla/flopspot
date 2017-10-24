<template>
<header class="wrapper">
  <img src="../../../../public/assets/logo_rgb_inverted_dark.svg"></img>
  <nav>
    <ul>
      <li><a id="home" href="#">Startseite</a></li>
      <li><a id="statistic" href="#">Statistiken</a></li>
    </ul>
  </nav>
</header>
</template>

<script>
export default {
  mounted: function() {
    this.setActive();
  },

  methods: {
    setActive: function() {
      let active;
      switch (window.location.pathname) {
        case "/statistic":
          active = document.getElementById("statistic").classList.add("active");
          break;
        case "/":
          active = document.getElementById("home").classList.add("active");
          break;
        default:
      }
    }
  }
}
</script>
