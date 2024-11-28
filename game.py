import tkinter as tk
from tkinter import messagebox
import random

class GuessTheNumberGame:
    def __init__(self, root):
        self.root = root
        self.root.title("Guess the Number")
        self.root.geometry("400x300")
        
        self.number_to_guess = random.randint(1, 100)
        self.attempts_left = 10
        
        self.label = tk.Label(root, text="Guess a number between 1 and 100", font=("Arial", 14))
        self.label.pack(pady=20)
        
        self.entry = tk.Entry(root, font=("Arial", 14))
        self.entry.pack(pady=10)
        
        self.submit_button = tk.Button(root, text="Submit", font=("Arial", 14), command=self.check_guess)
        self.submit_button.pack(pady=10)
        
        self.result_label = tk.Label(root, text="", font=("Arial", 12))
        self.result_label.pack(pady=10)
        
        self.attempts_label = tk.Label(root, text=f"Attempts left: {self.attempts_left}", font=("Arial", 12))
        self.attempts_label.pack(pady=10)
        
    def check_guess(self):
        try:
            guess = int(self.entry.get())
            if guess < 1 or guess > 100:
                self.result_label.config(text="Please enter a number between 1 and 100!", fg="red")
                return
            
            if guess == self.number_to_guess:
                messagebox.showinfo("Congratulations!", "You guessed the number correctly!")
                self.reset_game()
            elif guess < self.number_to_guess:
                self.result_label.config(text="Too low! Try again.", fg="blue")
            else:
                self.result_label.config(text="Too high! Try again.", fg="blue")
            
            self.attempts_left -= 1
            self.attempts_label.config(text=f"Attempts left: {self.attempts_left}")
            
            if self.attempts_left == 0:
                messagebox.showinfo("Game Over", f"You've run out of attempts! The number was {self.number_to_guess}.")
                self.reset_game()
        except ValueError:
            self.result_label.config(text="Invalid input! Enter a number.", fg="red")
    
    def reset_game(self):
        self.number_to_guess = random.randint(1, 100)
        self.attempts_left = 10
        self.result_label.config(text="")
        self.attempts_label.config(text=f"Attempts left: {self.attempts_left}")
        self.entry.delete(0, tk.END)

if __name__ == "__main__":
    root = tk.Tk()
    game = GuessTheNumberGame(root)
    root.mainloop()
