# 1.io.Copy()

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

# 2.ioutil.WriteFile（）和ioutil.ReadFile（）

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

# 3.os.Read（）和os.Write（）

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