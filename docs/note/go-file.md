# 文件操作

## 判断文件或文件夹是否存在
os.Stat()
- 如果返回的错误为nil,说明文件或文件夹存在
- 如果返回的错误类型使用os.IsNotExist()判断为true,说明文件或文件夹不存在
- 如果返回的错误为其它类型,则不确定是否在存在
```go
func PathExists(path string) (bool, error) {
	_, err := os.Stat(path)
	if err == nil {
		return true, nil
	}
	if os.IsNotExist(err) {
		return false, nil
	}
	return false, err
}
```

## 文件拷贝
### 1.io.Copy()
```go
func copy ( src , dst string ) ( int64 , error ) { 
    sourceFileStat , err := os . Stat ( src ) 
    if err != nil { 
            return 0 , err
    } 

    if ! sourceFileStat . Mode () . IsRegular () { 
            return 0 , fmt . Errorf ( "%s is not a regular file" , src ) 
    } 

    source , err := os . Open ( src ) 
    if err != nil { 
            return 0 , err
    } 
    defer source . Close () 

    destination , err := os . Create ( dst ) 
    if err != nil { 
            return 0 , err
    } 
    defer destination . Close () 
    nBytes , err := io . Copy ( destination , source ) 
    return nBytes , err
```
### 2.ioutil.WriteFile（）和ioutil.ReadFile（）
```go
input , err := ioutil . ReadFile ( sourceFile ) 
    if err != nil { 
            fmt . Println ( err ) 
            return 
    } 

    err = ioutil . WriteFile ( destinationFile , input , 0644 ) 
    if err != nil { 
            fmt . Println ( "Error creating" , destinationFile ) 
            fmt . Println ( err ) 
            return 
    }
```
### 3.os.Read（）和os.Write（）
```go
buf := make ([] byte , BUFFERSIZE ) 
    for { 
            n , err := source . Read ( buf ) 
            if err != nil && err != io . EOF { 
                    return err
            } 
            if n == 0 { 
                    break 
            } 

            if _ , err := destination . Write ( buf [: n ]); err != nil { 
                    return err
            } 
    } }
```