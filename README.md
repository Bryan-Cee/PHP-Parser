# PHP command line argument parser

---

Running the program involves passing in a list of arguments on the command line (in any order), of a certain form, for example:

- `php src/testArgs.php -v --grades=good -T 5 -l val1,val2,val3 --names=Mussaed,Yazeed,Mikhail`

For the first example, output would look something like:

```
FLAGS
v

SINGLES
T => 5 (1 argument)
l => [0] val1, [1] val2, [2] val3 (3 arguments)

DOUBLES
grades => good (1 argument)
names => [0] Mussaed, [1] Yazeed, [2] Mikhail (3 arguments)
```
