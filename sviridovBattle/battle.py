

SIZE = 10  

# Обозначения на поле:
#   "." — пустая клетка (вода)
#   "O" — клетка с кораблём (скрыта от противника)
#   "X" — попадание
#   "*" — промах

# Создание пустого поля

def create_field():
    """Возвращает поле 10x10, заполненное точками."""
    field = []
    for _ in range(SIZE):
        row = []
        for _ in range(SIZE):
            row.append(".")
        field.append(row)
    return field



#  вывод поля

def print_field(field, hide_ships=False, title="Поле"):
    """Печатает поле. hide_ships=True скрывает корабли (поле противника)."""
    print(f"\n=== {title} ===")
    # Заголовок с номерами столбцов
    header = "   "
    for col in range(1, SIZE + 1):
        header += f"{col:2d}"
    print(header)

    for i, row in enumerate(field):
        line = f"{i + 1:2d} "
        for cell in row:
            show = cell
            if hide_ships and cell == "O":
                show = "."  # прячем корабли противника
            line += f" {show}"
        print(line)
    print()


# Проверка вставляния корабля

def can_place_ship(field, cells):
    """Проверяет, что все клетки свободны и вокруг них нет других кораблей."""
    for (r, c) in cells:
        if r < 0 or r >= SIZE or c < 0 or c >= SIZE:
            return False
        if field[r][c] != ".":
            return False
        # Проверяем соседние клетки (включая диагонали) —
        # корабли не должны касаться друг друга
        for dr in (-1, 0, 1):
            for dc in (-1, 0, 1):
                nr, nc = r + dr, c + dc
                if 0 <= nr < SIZE and 0 <= nc < SIZE:
                    if field[nr][nc] == "O":
                        return False
    return True



# Размещение  корабля

def place_ship(field, ship_size, player_name):
    """Просит игрока ввести координаты и размещает корабль."""
    while True:
        print(f"\n{player_name}, разместите {ship_size}-палубный корабль.")
        try:
            row = int(input("  Номер строки (1-10): ")) - 1
            col = int(input("  Номер столбца (1-10): ")) - 1
        except ValueError:
            print("  Ошибка: введите целые числа.")
            continue

        if not (0 <= row < SIZE and 0 <= col < SIZE):
            print("  Ошибка: координаты должны быть от 1 до 10.")
            continue

     
        if ship_size == 1:
            cells = [(row, col)]
        else:
            direction = input("  Направление (h — горизонтально, v — вертикально): ").strip().lower()
            if direction not in ("h", "v"):
                print("  Ошибка: введите 'h' или 'v'.")
                continue

            cells = []
            for k in range(ship_size):
                if direction == "h":
                    cells.append((row, col + k))
                else:
                    cells.append((row + k, col))

        if can_place_ship(field, cells):
            for (r, c) in cells:
                field[r][c] = "O"
            print("  Корабль размещён!")
            return True
        else:
            print("  Нельзя разместить здесь: клетки заняты или корабли касаются друг друга.")



# Расстановление кораблей
def setup_fleet(field, player_name):
    """Расставляет флот: 4×1, 3×2, 2×3, 1×4."""
    print(f"\n{'=' * 40}")
    print(f"  Расстановка кораблей: {player_name}")
    print(f"{'=' * 40}")

    fleet = [4, 3, 2, 1]  # количество кораблей разного размера
    for ship_size in range(1, 5):
        count = fleet[ship_size - 1]
        for n in range(count):
            print_field(field, title=f"{player_name} — ваше поле")
            print(f"  Осталось разместить: {count - n} корабл(ей) размером {ship_size}")
            place_ship(field, ship_size, player_name)

    print_field(field, title=f"{player_name} — итоговое поле")



# удар по полю противника

def make_shot(enemy_field, enemy_ships, player_name):
    """
    Делает выстрел. Возвращает:
      (попал_ли, убит_ли_корабль)
    """
    while True:
        print(f"\n{player_name}, ваш выстрел!")
        try:
            row = int(input("  Строка (1-10): ")) - 1
            col = int(input("  Столбец (1-10): ")) - 1
        except ValueError:
            print("  Ошибка: введите целые числа.")
            continue

        if not (0 <= row < SIZE and 0 <= col < SIZE):
            print("  Ошибка: координаты от 1 до 10.")
            continue

        cell = enemy_field[row][col]
        if cell in ("X", "*"):
            print("  Вы уже стреляли сюда. Выберите другую клетку.")
            continue

    
        if cell == "O":
            enemy_field[row][col] = "X"
            print("  ПОПАДАНИЕ!")

           
            for ship in enemy_ships:
                if (row, col) in ship:
                    ship.remove((row, col))
                    if not ship:
                        print("  КОРАБЛЬ УНИЧТОЖЕН!")
                        return True, True  
                    else:
                        return True, False
            return True, False

        # Промах
        else:
            enemy_field[row][col] = "*"
            print("  Мимо!")
            return False, False



# Создание флота Джека Воробья

def create_ships(field):
    """Собирает список кораблей из поля (списки координат)."""
    visited = set()
    ships = []

    for r in range(SIZE):
        for c in range(SIZE):
            if field[r][c] == "O" and (r, c) not in visited:
                
                ship = []
                stack = [(r, c)]
                while stack:
                    cr, cc = stack.pop()
                    if (cr, cc) in visited:
                        continue
                    if 0 <= cr < SIZE and 0 <= cc < SIZE and field[cr][cc] == "O":
                        visited.add((cr, cc))
                        ship.append((cr, cc))
                        stack.append((cr - 1, cc))
                        stack.append((cr + 1, cc))
                        stack.append((cr, cc - 1))
                        stack.append((cr, cc + 1))
                ships.append(ship)
    return ships




def all_ships_destroyed(ships):
    """True, если все корабли потоплены (все списки пусты)."""
    for ship in ships:
        if ship:
            return False
    return True


# Сам игровой процесс

def main():
    print("=" * 50)
    print("        МОРСКОЙ БОЙ")
    print("=" * 50)
    print("Правила: у каждого игрока поле 10x10.")
    print("Флот: 4 однопалубных, 3 двухпалубных,")
    print("      2 трёхпалубных, 1 четырёхпалубный.")
    print("Корабли не должны касаться друг друга.\n")

    name1 = input("Имя первого игрока: ").strip() or "Игрок 1"
    name2 = input("Имя второго игрока: ").strip() or "Игрок 2"

    # Создаём поля
    field1 = create_field()
    field2 = create_field()

    # Расстановка кораблей
    print("\n" + "=" * 50)
    print("  ВАЖНО: во время расстановки второй игрок")
    print("  не должен смотреть на экран!")
    print("=" * 50)
    input(f"\n{name1}, нажмите Enter, чтобы начать расстановку...")
    setup_fleet(field1, name1)

    print("\n" * 3)
    input(f"{name1}, передайте управление {name2}. Нажмите Enter...")
    print("\n" * 3)

    input(f"{name2}, нажмите Enter, чтобы начать расстановку...")
    setup_fleet(field2, name2)

   
    ships1 = create_ships(field1)
    ships2 = create_ships(field2)

    print("\n" * 3)
    input("Расстановка завершена! Нажмите Enter, чтобы начать игру...")
    print("\n" * 3)

   
    current = 0  # 0 — ход первого, 1 — ход второго
    players = [
        {"name": name1, "enemy_field": field2, "enemy_ships": ships2, "own_field": field1},
        {"name": name2, "enemy_field": field1, "enemy_ships": ships1, "own_field": field2},
    ]

    while True:
        p = players[current]
        print("\n" * 2)
        print("=" * 50)
        print(f"  ХОД: {p['name']}")
        print("=" * 50)

        
        print_field(p["enemy_field"], hide_ships=True, title=f"Поле {p['name']} (ваши выстрелы)")
        print_field(p["own_field"], title="Ваше поле")

        shot_hit, ship_killed = make_shot(p["enemy_field"], p["enemy_ships"], p["name"])

       
        if all_ships_destroyed(p["enemy_ships"]):
            print("\n" * 2)
            print("=" * 50)
            print(f"  ПОБЕДА! {p['name']} уничтожил весь флот противника!")
            print("=" * 50)
            break

     
        if not shot_hit:
            current = 1 - current
            print(f"\nХод переходит к {players[current]['name']}.")
            input("Нажмите Enter, чтобы продолжить...")
        else:
            print("\nВы попали — ходите ещё раз!")
            input("Нажмите Enter, чтобы продолжить...")


if __name__ == "__main__":
    main()