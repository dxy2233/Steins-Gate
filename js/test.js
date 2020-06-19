// const isPalindrome = (str) => {
//   const newStr = str.replace(/[^0-9a-zA-Z]/g, '').toLowerCase()
//   const reverStr = newStr.split('').reverse().join('')
//   return newStr === reverStr
// }
const isPalindrome = (str) => {
  const newStr = str.replace(/[^0-9a-zA-Z]/g, '').toLowerCase()
  let left = 0
  let right = newStr.length - 1
  while (left < right) {
    if (newStr[left] !== newStr[right]) return false
    left++
    right--
  }
  return true
}

console.log(isPalindrome('A man, a plan, a canal: Panama'))
