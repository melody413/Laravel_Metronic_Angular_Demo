import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateAreaComponent } from './create-area.component';

describe('CreateAreaComponent', () => {
  let component: CreateAreaComponent;
  let fixture: ComponentFixture<CreateAreaComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateAreaComponent]
    });
    fixture = TestBed.createComponent(CreateAreaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
