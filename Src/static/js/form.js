( function() {
    const vm = new Vue({
      el: document.querySelector('#mount'),
      template: `
        <div>
          <h2>Rekisteröintilomake</h2>
          <ul class="vue-form" v-bind:class="[hasError ? 'vue-form-errors' : 'vue-form-success',]">
            <li v-for="message in messages">{{ message }}</li>
          </ul>
          <div>
            <div>
              <p>Sähköpostiosoite</p>
              <input type="email" v-model="email" />
            </div>

            <div>
              <p>Etunimi</p>
              <input type="text" v-model="firstName" />
            </div>

            <div>
              <p>Sukunimi</p>
              <input type="text" v-model="lastName" />
            </div>

            <div>
              <p>Ikä</p>
              <input type="number" v-model.number="age" />
            </div>

            <div>
              <button type="submit" v-on:click="submit">Lähetä</button>
            </div>
          </div>
        </div>
      `,
      data: () => ({
        email: null,
        firstName: null,
        lastName: null,
        age: null,
        messages: [],
        hasError: false
      }),
      methods: {
        submit: function() {
          this.formReset();
          const data = {
            firstName: this.firstName,
            lastName: this.lastName,
            email: this.email,
            age: this.age
          };
          
          const url = '/wp-json/vue-form/v1/register/';
          this.postData(url, data)
            .then(data => {
              if (this.hasError) {
                this.showErrors(data);
              } else {
                this.messages = ["Rekisteröinti onnistui"];
              }
              
            });
        },
        async postData(url, data) {
          const response = await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          });
          if (!response.ok) {
            this.hasError = true;
          }

          return response.json();
        },
        showErrors(data) {
          this.messages = Object.values(data);
        },
        formReset() {
          this.messages = [];
          this.hasError = false;
        }
      }
    });
  })();