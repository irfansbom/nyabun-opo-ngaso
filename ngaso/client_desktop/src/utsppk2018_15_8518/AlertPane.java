/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utsppk2018_15_8518;

import java.awt.Component;
import javax.swing.JOptionPane;

/**
 *
 * @author 15.8518
 */
public class AlertPane {
    public static void showException(Component c, String message) {
        JOptionPane.showMessageDialog(c, message, "Error", JOptionPane.ERROR_MESSAGE);
    }
    
    public static void showInformation(Component c, String message) {
        JOptionPane.showMessageDialog(c, message, "Info", JOptionPane.INFORMATION_MESSAGE);
    }
}
