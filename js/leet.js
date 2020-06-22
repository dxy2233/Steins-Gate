/* 验证回文串 */
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

/* 模式匹配 */
const patternMatching = (pattern, value) => {}

/* 两数之和 */
const twoSum = (nums, target) => {
  let i = nums.length
  while (i > 1) {
    let last = nums.pop()
    if (nums.indexOf(target - last) > -1) {
      return [nums.indexOf(target - last), nums.length]
    }
    i--
  }
}
// console.log(twoSum([2, 7, 11, 15], 9))

/* 无重复字符的最长子串 */
const lengthOfLongestSubstring = (s) => {
  const occ = new Set()
  return occ
}
console.log(lengthOfLongestSubstring('abcabcbb'))
