# WordPress Project with Staggs Plugin

## 📌 Project Overview
This project is a **WordPress-based CMS** built using the **Staggs plugin** for content management and custom functionalities. The project is designed to provide a streamlined experience for managing and displaying content dynamically while ensuring a responsive and user-friendly UI.

## 🚀 Tech Stack
- **WordPress** (CMS)
- **Elementor Hello Theme** (Lightweight theme for Elementor)
- **Elementor Page Builder** (Drag-and-drop site builder)
- **Staggs Plugin** (for custom content management)
- **PHP & MySQL** (Backend & Database)
- **HTML, CSS, JavaScript** (Frontend)
- **GitHub Pages** (for static deployment, if applicable)

## 🎨 Design Overview
The design for this project follows the guidelines set in **Figma**:
🔗 **Figma Link**: [CMS Dev Test Design](https://www.figma.com/design/OOjqEPkw2WmIcSqHLnQoIw/CMS-Dev-Test?node-id=0-1&m=dev&t=F4kx5MvIQwyD5Tu6-1)

### **Key Design Elements:**
- **Modern UI** with a clean and intuitive layout.
- **Responsive design** to ensure compatibility across devices.
- **Optimized content display** for readability and engagement.
- **Customizable elements** using Staggs plugin features.
- **Popup Info** per attribute from Staggs for enhanced UX.

## 📂 Project Structure
```
|-- wp-content/
|   |-- themes/
|       |-- hello-elementor/ (Active theme)
|   |-- plugins/
|       |-- staggs/ (Custom plugin for CMS features)
|   |-- uploads/
|       |-- faq.json (FAQ data storage)
|-- wp-config.php (Configuration file)
|-- index.php (Entry point)
|-- .gitignore (Git exclusions)
|-- README.md (Project documentation)
```

## ⚙️ Installation & Setup
### **Local Development (Using XAMPP or Local WP)**
1. Clone this repository:
   ```sh
   git clone https://github.com/nugrahaadis12/staggstest.git
   ```
2. Set up a local WordPress environment.
3. Import the database (`.sql` file if available).
4. Activate the **Hello Elementor Theme** and **Elementor Page Builder**.
5. Activate the **Staggs plugin** in WordPress Admin.
6. Configure permalinks and necessary settings.
7. Ensure FAQ data is stored in `wp-content/uploads/faq.json`.
8. Done! 🎉

## 🌐 Deployment (Static Site via Simply Static & GitHub Pages)
1. Install & configure **Simply Static Plugin**.
2. Generate static files from WordPress Admin.
3. Push static files to the `gh-pages` branch:
   ```sh
   git checkout -b gh-pages
   git add .
   git commit -m "Deploy static WordPress"
   git push origin gh-pages
   ```
4. Enable GitHub Pages in the repo settings.
5. Access the live site at:
   ```
   https://nugrahaadis12.github.io/staggstest/
   ```

## 📌 Custom Functionalities
- **FAQ Section** dynamically loaded from `wp-content/uploads/faq.json`.
- **Popup Info** per attribute from Staggs.
- **Custom Snippets** added using Code Snippets plugin.

## 📌 To-Do List
- [ ] Optimize static generation settings.
- [ ] Improve CSS for better responsiveness.
- [ ] Add caching for performance improvements.
- [ ] Document API endpoints if using headless WordPress.

## 💡 Contributing
If you'd like to contribute, feel free to fork this repo, make improvements, and submit a pull request! 🎯

---
© 2025 [Your Name / Team Name] - Built with ❤️ using WordPress, Elementor & Staggs Plugin.
