
board = ["1", "2", "3", "4", "5", "6", "7", "8", "9"]

for turn in range(9):
    # Определяем, чей сейчас ход
    if turn % 2 == 0:
        player = "X"
        text_player = "Крестики (X)"
    else:
        player = "O"
        text_player = "Нолики (O)"


    render_board = (
        f"{board[0]} | {board[1]} | {board[2]}\n"
        f"--------\n"
        f"{board[3]} | {board[4]} | {board[5]}\n"
        f"---------\n"
        f"{board[6]} | {board[7]} | {board[8]}\n\n"
        f"Ход № {turn + 1}. Сейчас ходят: {text_player}\n"
        f"Введите номер клетки (1-9): "
    )

    # Выводим всё это добро прямо во всплывающее окно input
    choice = int(input(render_board))

    # Ставим знак игрока в выбранную клетку
    board[choice - 1] = player

    # Проверяем все возможные варианты победы
    if (board[0] == board[1] == board[2] or  # Первая строка
        board[3] == board[4] == board[5] or  # Вторая строка
        board[6] == board[7] == board[8] or  # Третья строка
        board[0] == board[3] == board[6] or  # Первый столбец
        board[1] == board[4] == board[7] or  # Второй столбец
        board[2] == board[5] == board[8] or  # Третий столбец
        board[0] == board[4] == board[8] or  # Главная диагональ
        board[2] == board[4] == board[6]):   # Побочная диагонал
        # Финальный показ поля при победе (выводим через обычный print, когда игра окончена)
        print(f"{board[0]} | {board[1]} | {board[2]}\n---------\n{board[3]} | {board[4]} | {board[5]}\n---------\n{board[6]} | {board[7]} | {board[8]}\n")
        print(f"Победили {text_player}! ")
        break
else:
    # Финальный показ поля при ничьей
    print(f"{board[0]} | {board[1]} | {board[2]}\n---------\n{board[3]} | {board[4]} | {board[5]}\n---------\n{board[6]} | {board[7]} | {board[8]}\n")
    print("Ничья! Свободных мест нет.")