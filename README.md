# 🗳️ Community Voting System

A secure and offline-ready voting system built with **Laravel**, designed for local community elections. Voters cast their votes using **6-digit codes** provided to them, and the voting process is monitored in real-time from an admin dashboard.

---

## 🚀 Features

- 🔐 **Code-Based Voter Authentication** – Each voter is assigned a unique 6-digit code to vote once.
- 📵 **Offline-First** – Designed to work in local environments without requiring constant internet access.
- 📊 **Live Monitoring** – Admin dashboard to track voter participation and vote counts in real time.
- ❌ **Double-Vote Protection** – Ensures each voter can vote only once.
- 🧑‍💼 **Admin Panel** – Secure backend for managing users, codes, and monitoring the election process.
- 📱 **Mobile Voting Interface** – Voters use their phones to access the voting page with their code.

---

## 📂 Project Structure
├── app/
│ ├── Http/Controllers/
│ │ ├── Auth/
│ │ ├── Admin/
│ │ └── VoteController.php
├── resources/views/
│ ├── welcome.blade.php
│ ├── vote.blade.php
│ └── admin/
│ ├── dashboard.blade.php
│ └── results.blade.php
├── routes/
│ └── web.php
├── database/
│ ├── migrations/
│ └── seeders/


##✍️ Credits
###Made by Shuhaily Casan
###Built with Laravel + Livewire
