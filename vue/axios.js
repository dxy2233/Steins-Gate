      this.axios.post('', {
        NewPwd: this.npwd,
        OldPwd: this.opwd}, {
          headers: {token: localStorage.token}
        }).then((response) => {
          if (response.data.) {
          } else {
            
          }
        })


      this.axios.post('',
        null, {
          headers: {token: this.$store.state.login.token}
        }).then((response) => {
          if (response.data.) {
          }
        })


      this.axios.get('', {
        headers: {token: this.$store.state.login.token}
      }).then((response) => {
        console.log(response.data)
      })