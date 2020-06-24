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

/* 二进制求和 */
const addBinary = (a, b) => {
  return (BigInt('0b' + a) + BigInt('0b' + b)).toString(2)
}
// console.log(addBinary('11', '1'))

/* 最接近的三数之和 */
const threeSumClosest = (nums, target) => {
  // 暴力解法
  // let res = nums[0] + nums[1] + nums[2]
  // while (nums.length > 2) {
  //   const firstNum = nums.shift()
  //   for (let index = 0; index < nums.length; index++) {
  //     const threeNums = nums.slice(index + 1)
  //     for (let index2 = 0; index2 < threeNums.length; index2++) {
  //       const sum = firstNum + nums[index] + threeNums[index2]
  //       if (Math.abs(sum - target) < Math.abs(res - target)) res = sum
  //     }
  //   }
  // }
  // return res
  // 双指针
  nums.sort((a, b) => a - b)
  let res = nums[0] + nums[1] + nums[2]
  let len = nums.length
  for (let i = 0; i < len - 2; i++) {
    let left = i + 1
    let right = len - 1
    while (left < right) {
      const sum = nums[i] + nums[left] + nums[right]
      if (Math.abs(res - target) > Math.abs(sum - target)) res = sum
      sum > target ? right-- : left++
    }
  }
  return res
}
console.log(threeSumClosest([-1, 2, 1, -4], 1))
// console.log(threeSumClosest([-1, 0, 1, 2, -1, -4], 0))
