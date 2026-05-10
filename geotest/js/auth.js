function showLoginForm() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('registerForm').style.display = 'none';
    
    clearMessages();
}

function showRegisterForm() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';

    clearMessages();
}

function clearMessages() {
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => {
        msg.textContent = '';
        msg.className = 'message';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    
    if (error === 'login') {
        showLoginForm();
        
        const loginMessage = document.getElementById('loginMessage');
        if (loginMessage) {
            loginMessage.textContent = 'Ошибка входа. Проверьте данные.';
            loginMessage.className = 'message error-message';
        }
    } else if (error === 'register') {
        showRegisterForm();
        const registerMessage = document.getElementById('registerMessage');
        if (registerMessage) {
            registerMessage.textContent = 'Ошибка регистрации. Проверьте данные.';
            registerMessage.className = 'message error-message';
        }
    }
});

document.getElementById('loginFormElement')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageDiv = document.getElementById('loginMessage');
    
    try {
        const response = await fetch('auth/login.php', {
            method: 'POST',
            body: formData
        });
        
        if (response.redirected) {
            window.location.href = response.url;
            return;
        }
        
        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            messageDiv.textContent = data.message || 'Ошибка входа';
            messageDiv.className = 'message error-message';
        }
    } catch (error) {
        messageDiv.textContent = 'Ошибка соединения с сервером';
        messageDiv.className = 'message error-message';
    }
});

document.getElementById('registerFormElement')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageDiv = document.getElementById('registerMessage');
    
    try {
        const response = await fetch('auth/register.php', {
            method: 'POST',
            body: formData
        });
        
        if (response.redirected) {
            window.location.href = response.url;
            return;
        }
        
        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            messageDiv.textContent = data.message || 'Ошибка регистрации';
            messageDiv.className = 'message error-message';
        }
    } catch (error) {
        messageDiv.textContent = 'Ошибка соединения с сервером';
        messageDiv.className = 'message error-message';
    }
});