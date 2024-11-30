import java.util.*;
public class Encryption {
    static Scanner s1 = new Scanner(System.in);
    public static void main(String ar[]) {
        System.out.println("Name:Dhruv\nRoll no:2210997071 ");
        int num;
        System.out.println("enter the number :");
        num = s1.nextInt();
        int temp = num;
        int t = num;
        System.out.println("===Binary number===");
        int a[] = new int[40];
        int i = 0;
        while (temp > 0) {
            int temp2 = temp % 2;
            a[i] = temp2;
            temp = temp / 2;
            i++;
        }
        for (int j = i - 1; j >= 0; j--) {
            System.out.print(a[j]);
        }
        i = 0;
        System.out.println("\n===Encrypted number===");
        while (t > 0) {
            int temp2 = t % 2;
            a[i] = ~temp2;
            t = t / 2;
            i++;
        }
        for (int j = i - 1; j >= 0; j--)
        {
            System.out.print(a[j]);
        }
        int p[] = new int[40];
        i = 0;
        System.out.println("\n===Original  number Again  ===");
        while (num > 0) {
            p[i] = ~a[i];
            num = num / 2;
            i++;
        }
        for (int j = i - 1; j >= 0; j--)
        {
            System.out.print(p[j]);
        }
    }
}
