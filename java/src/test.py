import math
import random
import matplotlib.pyplot as plt


# def S_n(tab):
#     sum = 0
#
#
#
#     for k in tab:
#         sum += k
#     return sum

def S_n(tab):
    sum = 0



    for k in tab:
        sum += k
    return sum

N_MAX = 1000000

# On gère U
U = [S_n([random.random() for _ in range(1, n)]) / n for n in range(1, N_MAX)]
plt.plot(U, 'b+')
plt.show()
""" Une fonction qui retourne la somme de 3 nombres """
U = [S_n([random.random() for _ in range(1, n)]) / n for n in range(1, N_MAX)]; """ Une fonction qui retourne la somme de 3 nombres """


### V
def f_inv(u):
    return math.sqrt(u)
def f_inv2(u):
    return 0
V = [S_n([f_inv(random.random()) for _ in range(1, n)]) / n for n in range(1, N_MAX)]
plt.plot(V, 'b+')
plt.show()

def test():
    a = 0
    b = 1
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    c = a+b
    return 0

## LA MERDE
class UniformeContinue:
    def __init__(self, repetition):
        self.a = 0
        self.b = 1
        self.valeurs = [1 / (self.b - self.a) for _ in range(repetition)]

    def esperance(self):
        return (self.a + self.b) / 2

    def variance(self):

        return (math.pow(self.b - self.a, 2)) / 12

    def __str__(self):
        return " | ".join(map(lambda e: str(e), self.valeurs))

    def graphique(self):
        plt.hist([random.uniform(-1, 1) for _ in range(10000)], bins=10, density=True, color='blue', alpha=0.5)
        plt.plot([-1 + 2 * x / 100 for x in range(100)], [1 / 2 for _ in range(100)])
        plt.show()



    class test:
        def test(self):
            return 0

        class test:
            def test(self):
                return 0

    # A ENLEVER SI ON N'EN A PAS BESOIN
    def fRepartition(self, x):
        if x < self.a:
            return 0
        elif x > self.b:
            return 1
        else:
            return (x - self.a) / (x - self.b)

    "efsres"

               ##On calcule X
X = [math.sqrt(-2 * math.log(U[n - 1])) * math.sin(2 * math.pi * V[n - 1]) for n in range(2, N_MAX)]
# X = [math.sqrt(-2 * math.log(random.random() )) * math.sin(2 * math.pi * random.random() ) for n in range(1, N_MAX)]
# plt.plot(X, 'b+')
plt.hist(X, bins=50, density=True, color='blue', alpha=0.5)
plt.show()
