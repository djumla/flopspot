<template>
  <footer>
    <div id="service">
      <div id="flex-service">
        <section id="contact">
          <h1 class="underlined">Fragen oder Anregungen?</h1>
          <h2> Schreib uns an <a href="#">kontakt@flopspot.de</a></h2>
        </section>
        <section id="social-media">
          <h1 class="underlined">Werde ein Fan von flopspot</h1>
          <div>
            <h2>Folge uns auf Facebook oder Twitter</h2>
            <a href="https://www.facebook.com/Flopspot-160124607925841/">
              <img src="/assets/facebook.png">
            </a>
            <a href="https://twitter.com/FlopspotDE/">
              <img src="/assets/twitter.png">
            </a>
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
        <div
          class="tweet"
          v-for="tweet in tweets"
          :key="tweet.id"
        >
          <span class="title underlined">{{ tweet.title }}</span>
          <p>{{ tweet.content }}</p>
        </div>
      </section>
    </div>
    <div id="copyright">Copyright 2017 - flopspot</div>
  </footer>
</template>

<script>
  import Axios from 'axios'

  export default {

    data () {
      return {
        tweets: []
      }
    },

    mounted: function () {
      this.$nextTick(function () {
        this.createTweets()
      })
    },

    methods: {
      /**
       * @returns {void}
       */
      createTweets: function () {
        const self = this

        Axios.get('/api/tweets')
          .then((response) => {
            response.data.statuses.forEach(function (val, key) {
              let postDate = val.created_at.replace('+0000', '')
              if (key < 5) {
                self.tweets.push({id: key, title: postDate, content: val.text})
              }
            })
          })
      }
    }
  }
</script>
