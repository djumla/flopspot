<template>
<footer>
  <div id="service">
    <div id="flex-service">
      <section id="contact">
        <h1 class="underlined">Fragen oder Anregungen?</h1>
        <h2> Schreib uns an <a href="#">kontakt@flopspot.de</a> </h2>
      </section>
      <section id="social-media">
        <h1 class="underlined">Werde ein Fan von flopspot</h1>
        <div>
          <h2>Folge uns auf Facebook oder Twitter</h2>
          <a href="#"><img src="/assets/facebook.png"></img></a>
          <a href="https://twitter.com/FlopspotDE/"><img src="/assets/twitter.png"></img></a>
        </div>
      </section>
      <nav class="underlined">
        <ul>
          <li><a href="/imprint">Impressum</a></li>
          <li><a href="/contact">Kontakt</a></li>
          <li><a href="/privacyPolicy">Datenschutz</a></li>
        </ul>
      </nav>
    </div>
    <section id="tweets">
      <!-- Auto injection here -->
    </section>
  </div>
  <div id="copyright">Copyright 2017 - flopspot</div>
</footer>
</template>

<script>
import Axios from 'axios';

export default {
  mounted: function() {
    this.$nextTick(function() {
      this.createTweets();
    })
  },

  methods: {
    /**
     * @return {void}
     */
    createTweets: function() {
      Axios.get('/api/get/tweets')
        .then(function(response) {
          response.data.statuses.forEach(function(val, key) {
            let postDate = val.created_at.replace('+0000', "");

            if (key < 5) {
              /**
               * Every tweet has its own div
               * Also, of course, every tweet has a node and a headline
               * Tweet structure: Div > headline > text
               */

              // Headline
              let span = document.createElement('span');
              let spanText = document.createTextNode(postDate);

              // Tweet itself
              let p = document.createElement('p');
              let pText = document.createTextNode(val.text);

              let tweetContainer = document.createElement('div');

              tweetContainer.className = "tweet";
              span.className = "title underlined";

              span.appendChild(spanText);
              p.appendChild(pText);

              document.getElementById('tweets').appendChild(tweetContainer);

              tweetContainer.appendChild(span);
              tweetContainer.appendChild(p);
            }
          });

        })
    },

    dateFormatting: function(date) {
      return date.replace("+0000");
    }
  }
}
</script>
