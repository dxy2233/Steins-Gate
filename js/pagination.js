    pagination (data) {
      var array = []
      var startNum = 0
      var endNum = 0
      this.total = data.length
      startNum = (this.currentPage - 1) * this.pageSize
      if (this.currentPage * this.pageSize < this.total) {
        endNum = this.currentPage * this.pageSize
      } else {
        endNum = this.total
      }
      array = data.slice(startNum, endNum)
      return array
    }

//currentPage 当前页
//pageSize 每页的数据量
//total 数据总量